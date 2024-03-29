<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Controller;

use App\Discography\DiscographyManager;
use App\Entity\Album;
use App\Repository\AlbumRepository;
use Knp\Menu\MenuItem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Class DefaultController.
 */
#[Route(path: '/discographie')]
final class DiscographyController extends AbstractController
{
    public function __construct(
        private readonly DiscographyManager $discographyManager,
        private readonly MenuItem $appMainMenu,
        private readonly Environment $twig,
        private readonly AlbumRepository $albumRepository
    ) {
    }

    /**
     * Lists all Album entities.
     */
    #[Route(path: '/', name: 'discography', methods: ['GET'])]
    public function index(): Response
    {
        return new Response($this->twig->render('discography/index.html.twig', [
            'entities' => $this->discographyManager->getPublicAlbums(),
        ]));
    }

    /**
     * Finds and displays Album entity.
     */
    #[Route(path: '/album/id/{album}', name: 'discography_album_show', methods: ['GET'])]
    #[Route(path: '/album/{album}.html', name: 'discography_album_show_rewrite', methods: ['GET'])]
    public function show(Request $request, $album): Response
    {
        $entity = is_numeric($album) ? $this->albumRepository->find($album) : $this->albumRepository->getAlbumByUrlKey($album);

        if ( ! $entity) {
            throw $this->createNotFoundException('Unable to find Album entity.');
        }

        // Init Main Menu
        $this->appMainMenu->getChild('Discographie')->setCurrent(true);

        $request->attributes->set('label', $entity->getTitle());

        return new Response($this->twig->render('discography/show.html.twig', [
            'entity' => $entity,
        ]));
    }
}
