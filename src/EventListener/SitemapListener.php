<?php

namespace App\EventListener;

use App\Discography\DiscographyManager;
use App\Entity\Article;
use App\Entity\Evenement;
use App\Event\Sitemap\GenerateEvent;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Router;

/**
 * Class PostListener.
 */
class SitemapListener
{
    private $em;
    private $router;
    private $discographyManager;

    /**
     * SitemapListener constructor.
     *
     * @param Router             $router
     * @param DiscographyManager $discographyManager
     */
    public function __construct(Router $router, DiscographyManager $discographyManager, ObjectManager $entityManager)
    {
        $this->router = $router;
        $this->discographyManager = $discographyManager;
        $this->em = $entityManager;
    }

    /**
     * @param GenerateEvent $event
     */
    public function onGenerateSitemapEvent(GenerateEvent $event)
    {
        /** Blog */
        // Add blog url
        $mainUrl = [
            'loc' => $this->router->generate('blog'),
            'changefreq' => 'weekly',
            'priority' => '0.80',
        ];
        $event->addUrls($mainUrl);

        // add some urls blog
        $repositoryArticle = $this->em->getRepository(Article::class);
        $entitiesBlog = $repositoryArticle->getPublicArticles(1, [], 100);

        // add some urls blog
        foreach ($entitiesBlog as $article) {
            if (!$article->getUrl()) {
                continue;
            }

            $urlArticleBlog = [
                'loc' => $this->router->generate('blog_show', ['slug' => $article->getSlug()]),
                'changefreq' => 'weekly',
                'priority' => '0.50',
            ];
            $event->addUrls($urlArticleBlog);
        }

        /** Contact */
        // Add main url
        $mainUrl = [
            'loc' => $this->router->generate('aml_contactus_default_index'),
            'changefreq' => 'weekly',
            'priority' => '0.80',
        ];
        $event->addUrls($mainUrl);

        /** Discography */
        // Add main url
        $mainUrl = [
            'loc' => $this->router->generate('discography'),
            'changefreq' => 'weekly',
            'priority' => '0.80',
        ];
        $event->addUrls($mainUrl);

        // Add some urls of discography
        foreach ($this->discographyManager->getPublicAlbums() as $album) {
            if (!$album->getUrl()) {
                continue;
            }

            $urlAlbum = $this->router->generate('discography_album_show_rewrite', [
                'url_key' => $album->getUrl()->getUrlKey(),
            ]);

            if (empty($urlAlbum)) {
                $urlAlbum = $this->router->generate('discography_album_show', ['id' => $album->getId()]);
            }

            $urlAlbumDiscography = [
                'loc' => $urlAlbum,
                'changefreq' => 'weekly',
                'priority' => '0.50',
            ];
            $event->addUrls($urlAlbumDiscography);
        }

        /** Evenements */
        // add main url
        $mainUrl = [
            'loc' => $this->router->generate('agenda'),
            'changefreq' => 'weekly',
            'priority' => '0.80',
        ];
        $event->addUrls($mainUrl);

        // add some urls fo agenda events
        $evenementRepository = $this->em->getRepository(Evenement::class);
        $agendaEvents = $evenementRepository->getNextEvenements([
            'public' => 1,
            'archive' => 0,
            'type' => Evenement::EVENEMENT_TYPE_CONCERT,
        ]);

        foreach ($agendaEvents as $agendaEvent) {
            if (!$agendaEvent->getUrl()) {
                continue;
            }

            $urlEventAgenda = [
                'loc' => $this->router->generate('agenda_show_event', ['slug' => $agendaEvent->getSlug()]),
                'changefreq' => 'weekly',
                'priority' => '0.50',
            ];
            $event->addUrls($urlEventAgenda);
        }
    }
}
