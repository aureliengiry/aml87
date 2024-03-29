<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Article;
use App\Repository\AlbumRepository;
use App\Repository\ArticleRepository;
use App\Sitemap\SitemapGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

final class DefaultController extends AbstractController
{
    public function __construct(
        private readonly Environment $twig,
        private readonly SitemapGenerator $sitemap,
        private readonly ArticleRepository $articleRepository,
        private readonly AlbumRepository $albumRepository
    ) {
    }

    #[Route(path: '/', name: 'app_main_index', methods: ['GET'])]
    public function index(): Response
    {
        // Last blog article
        $blogEntity = $this->articleRepository->findOneBy(
            ['public' => Article::ARTICLE_IS_PUBLIC],
            ['created' => 'DESC']
        );

        // Last Album
        $albumEntity = $this->albumRepository->findOneBy(
            ['public' => Album::ALBUM_IS_PUBLIC],
            ['date' => 'DESC']
        );

        return new Response($this->twig->render(
            'default/index.html.twig',
            [
                'lastBlogArticle' => $blogEntity,
                'lastAlbum' => $albumEntity,
            ]
        ));
    }

    #[Route(path: '/sitemap.{_format}', name: 'sitemap', requirements: ['_format' => 'xml'], methods: ['GET'])]
    public function sitemap(Request $request): Response
    {
        return new Response($this->twig->render(
            'default/sitemap.xml.twig',
            [
                'urls' => $this->sitemap->getUrls(),
                'hostname' => $request->getSchemeAndHttpHost(),
            ]
        ));
    }

    #[Route(path: '/google-analytics', name: 'google-analytics', methods: ['GET'])]
    public function googleAnalytics(): Response
    {
        return new Response($this->twig->render('main/google_analytics.html.twig', [
            'ga_id' => $this->getParameter('app_google_analytics.account_id'),
        ]));
    }
}
