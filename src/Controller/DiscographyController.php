<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Controller;

use App\Discography\DiscographyManager;
use App\Entity\Album;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController.
 *
 * @Route("/discographie")
 */
class DiscographyController extends Controller
{
    /**
     * Lists all Album entities.
     *
     * @Route("/", name="discography")
     * @Template("discography/index.html.twig")
     * @Method("GET")
     */
    public function index()
    {
        return ['entities' => $this->container->get(DiscographyManager::class)->getPublicAlbums()];
    }

    /**
     * Finds and displays a Album entity.
     *
     * @Route("/album/id/{album}", name="discography_album_show")
     * @Route("/album/{album}.html", name="discography_album_show_rewrite")
     * @Template("discography/show.html.twig")
     * @Method("GET")
     */
    public function show(Request $request, $album)
    {
        $em = $this->getDoctrine()->getManager();

        $albumRepository = $em->getRepository(Album::class);
        if (is_numeric($album)) {
            $entity = $albumRepository->find($album);
        } else {
            $entity = $albumRepository->getAlbumByUrlKey($album);
        }

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Album entity.');
        }

        // Init Main Menu
        $menu = $this->get('app.main_menu');
        $menu->getChild('Discographie')->setCurrent(true);

        $request->attributes->set('label', $entity->getTitle());

        return [
            'entity' => $entity,
        ];
    }
}
