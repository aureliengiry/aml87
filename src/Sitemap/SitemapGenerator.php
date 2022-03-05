<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Sitemap;

use App\Discography\DiscographyManager;
use App\Entity\Evenement;
use App\Repository\ArticleRepository;
use App\Repository\EvenementRepository;
use Symfony\Component\Routing\RouterInterface;

class SitemapGenerator
{
    private array $urls = [];

    private RouterInterface $router;
    private DiscographyManager $discographyManager;
    private ArticleRepository $articleRepository;
    private EvenementRepository $evenementRepository;

    public function __construct(
        RouterInterface $router,
        DiscographyManager $discographyManager,
        ArticleRepository $articleRepository,
        EvenementRepository $evenementRepository
    ) {
        $this->router = $router;
        $this->discographyManager = $discographyManager;
        $this->articleRepository = $articleRepository;
        $this->evenementRepository = $evenementRepository;
    }

    public function addUrls(array $url): void
    {
        $this->urls[] = $url;
    }

    public function getUrls(): array
    {
        // add some urls homepage
        $this->addUrls([
            'loc' => $this->router->generate('app_main_index'),
            'changefreq' => 'weekly',
            'priority' => '1.0',
        ]);

        /* Blog */
        // Add blog url
        $this->addUrls([
            'loc' => $this->router->generate('blog'),
            'changefreq' => 'weekly',
            'priority' => '0.80',
        ]);

        $entitiesBlog = $this->articleRepository->getPublicArticles(1, [], 100);

        // add some urls blog
        foreach ($entitiesBlog as $article) {
            if ( ! $article->getUrl()) {
                continue;
            }

            $urlArticleBlog = [
                'loc' => $this->router->generate('blog_show', ['slug' => $article->getSlug()]),
                'changefreq' => 'weekly',
                'priority' => '0.50',
            ];
            $this->addUrls($urlArticleBlog);
        }

        /* Contact */
        // Add main url
        $this->addUrls([
            'loc' => $this->router->generate('aml_contactus_default_index'),
            'changefreq' => 'weekly',
            'priority' => '0.80',
        ]);

        /* Discography */
        // Add main url
        $this->addUrls([
            'loc' => $this->router->generate('discography'),
            'changefreq' => 'weekly',
            'priority' => '0.80',
        ]);

        // Add some urls of discography
        foreach ($this->discographyManager->getPublicAlbums() as $album) {
            if ( ! $album->getUrl()) {
                continue;
            }

            $urlAlbum = $this->router->generate('discography_album_show_rewrite', [
                'album' => $album->getUrl()->getUrlKey(),
            ]);

            if (empty($urlAlbum)) {
                $urlAlbum = $this->router->generate('discography_album_show', ['album' => $album->getId()]);
            }

            $urlAlbumDiscography = [
                'loc' => $urlAlbum,
                'changefreq' => 'weekly',
                'priority' => '0.50',
            ];
            $this->addUrls($urlAlbumDiscography);
        }

        /* Evenements */
        // add main url
        $this->addUrls([
            'loc' => $this->router->generate('agenda'),
            'changefreq' => 'weekly',
            'priority' => '0.80',
        ]);

        // add some urls fo agenda events
        $agendaEvents = $this->evenementRepository->getNextEvenements([
            'public' => 1,
            'archive' => 0,
            'type' => Evenement::EVENEMENT_TYPE_CONCERT,
        ]);

        foreach ($agendaEvents as $agendaEvent) {
            if ( ! isset($agendaEvent['slug']) || empty($agendaEvent['slug'])) {
                continue;
            }

            $urlEventAgenda = [
                'loc' => $this->router->generate('agenda_show_event', ['slug' => $agendaEvent['slug']]),
                'changefreq' => 'weekly',
                'priority' => '0.50',
            ];
            $this->addUrls($urlEventAgenda);
        }

        return $this->urls;
    }
}
