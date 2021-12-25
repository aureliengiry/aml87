<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Article;
use App\Event\Sitemap\GenerateEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

final class DefaultController extends AbstractController
{
    private Environment $twig;

    public function __construct(
        Environment $twig
    ) {
        $this->twig = $twig;
    }

    /**
     * @Route("/", name="app_main_index", methods={"GET"})
     */
    public function index(): Response
    {
        // Last blog article
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $blogEntity = $repo->findOneBy(
            ['public' => Article::ARTICLE_IS_PUBLIC],
            ['created' => 'DESC']
        );

        // Last Album
        $repo = $this->getDoctrine()->getRepository(Album::class);
        $albumEntity = $repo->findOneBy(
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

    /**
     * @Route("/sitemap.{_format}", name="sitemap", Requirements={"_format" = "xml"}, methods={"GET"})
     */
    public function sitemap(Request $request, EventDispatcher $eventDispatcher): Response
    {
        $urls = [];

        // add some urls homepage
        $urls[] = [
            'loc' => $this->get('router')->generate('home'),
            'changefreq' => 'weekly',
            'priority' => '1.0',
        ];

        $sitemapGenerationEvent = new GenerateEvent($urls);
        $eventDispatcher->dispatch($sitemapGenerationEvent, 'aml_web.sitemap.generate_start');

        return new Response($this->twig->render(
            'default/sitemap.xml.twig',
            [
                'urls' => $sitemapGenerationEvent->getUrls(),
                'hostname' => $request->getSchemeAndHttpHost(),
            ]
        ));
    }

    /**
     * @Route("/google-analytics", name="google-analytics", methods={"GET"})
     */
    public function googleAnalytics(): Response
    {
        return new Response($this->twig->render('main/google_analytics.html.twig', [
            'ga_id' => $this->getParameter('app_google_analytics.account_id'),
        ]));
    }
}
