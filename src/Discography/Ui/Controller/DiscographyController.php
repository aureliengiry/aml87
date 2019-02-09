<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Discography\Ui\Controller;

use App\Core\Infrastructure\Adapter\Doctrine\DiscographyRepositoryDoctrineAdapter;
use App\Discography\Domain\DiscographyRepositoryInterface;
use App\Discography\Domain\Exception\AlbumNotFoundException;
use Knp\Menu\MenuItem;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController.
 *
 * @Route("/discographie")
 */
class DiscographyController extends AbstractController
{
    /** @var DiscographyRepositoryInterface */
    private $obtainDiscography;

    /** @var MenuItem */
    private $appMainMenu;

    public function __construct(DiscographyRepositoryDoctrineAdapter $discographyDoctrineAdapter, MenuItem $appMainMenu)
    {
        $this->obtainDiscography = $discographyDoctrineAdapter;
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
        return ['albums' => $this->obtainDiscography->getPublicAlbums()];
    }

    /**
     * Finds and displays a Album entity.
     *
     * @Route("/album/id/{album}", name="discography_album_show", methods={"GET"})
     * @Route("/album/{album}.html", name="discography_album_show_rewrite", methods={"GET"})
     * @Template("discography/show.html.twig")
     */
    public function show(Request $request, string $album)
    {
        try {
            $album = $this->obtainDiscography->getAlbumBySlug($album);

            // Init Main Menu
            $this->appMainMenu->getChild('Discographie')->setCurrent(true);
            $request->attributes->set('label', $album->getTitle());
        } catch (AlbumNotFoundException $albumNotFoundException) {
            throw $this->createNotFoundException($albumNotFoundException->getMessage());
        }

        return [
            'album' => $album,
        ];
    }
}
