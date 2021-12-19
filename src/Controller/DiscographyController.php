<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Controller;

use App\Discography\DiscographyManager;
use App\Entity\Album;
use Knp\Menu\MenuItem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Class DefaultController.
 *
 * @Route("/discographie")
 */
final class DiscographyController extends AbstractController
{
    private DiscographyManager $discographyManager;
    private MenuItem $appMainMenu;
    private Environment $twig;

    public function __construct(DiscographyManager $discographyManager, MenuItem $appMainMenu)
    {
        $this->discographyManager = $discographyManager;
        $this->appMainMenu = $appMainMenu;
    }

    /**
     * Lists all Album entities.
     *
     * @Route("/", name="discography", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('discography/index.html.twig', ['entities' => $this->discographyManager->getPublicAlbums()]);
    }

    /**
     * Finds and displays Album entity.
     *
     * @Route("/album/id/{album}", name="discography_album_show", methods={"GET"})
     * @Route("/album/{album}.html", name="discography_album_show_rewrite", methods={"GET"})
     */
    public function show(Request $request, $album): Response
    {
        $em = $this->getDoctrine()->getManager();

        $albumRepository = $em->getRepository(Album::class);
        if (is_numeric($album)) {
            $entity = $albumRepository->find($album);
        } else {
            $entity = $albumRepository->getAlbumByUrlKey($album);
        }

        if ( ! $entity) {
            throw $this->createNotFoundException('Unable to find Album entity.');
        }

        // Init Main Menu
        $this->appMainMenu->getChild('Discographie')->setCurrent(true);

        $request->attributes->set('label', $entity->getTitle());

        return $this->render('discography/show.html.twig', [
            'entity' => $entity,
        ]);
    }
}
