<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Controller;

use App\Discography\DiscographyManager;
use App\Entity\Album;
use Knp\Menu\MenuItem;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController.
 *
 * @Route("/discographie")
 */
class DiscographyController extends AbstractController
{
    /** @var DiscographyManager */
    private $discographyManager;

    /** @var MenuItem */
    private $appMainMenu;

    public function __construct(DiscographyManager $discographyManager, MenuItem $appMainMenu)
    {
        $this->discographyManager = $discographyManager;
        $this->appMainMenu = $appMainMenu;
    }

    /**
     * Lists all Album entities.
     *
     * @Route("/", name="discography", methods={"GET"})
     * @Template("discography/index.html.twig")
     */
    public function index()
    {
        return ['entities' => $this->discographyManager->getPublicAlbums()];
    }

    /**
     * Finds and displays a Album entity.
     *
     * @Route("/album/id/{album}", name="discography_album_show", methods={"GET"})
     * @Route("/album/{album}.html", name="discography_album_show_rewrite", methods={"GET"})
     * @Template("discography/show.html.twig")
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
        $this->appMainMenu->getChild('Discographie')->setCurrent(true);

        $request->attributes->set('label', $entity->getTitle());

        return [
            'entity' => $entity,
        ];
    }
}
