<?php

namespace Aml\Bundle\DiscographyBundle\EventListener;

use Aml\Bundle\DiscographyBundle\Discography\DiscographyManager;
use Aml\Bundle\WebBundle\Event\Sitemap\GenerateEvent;
use Symfony\Component\Routing\Router;

/**
 * Class PostListener
 * @package Aml\Bundle\DiscographyBundle\EventListener
 */
class SitemapListener
{
    private $router;
    private $discographyManager;

    /**
     * SitemapListener constructor.
     *
     * @param Router $router
     * @param DiscographyManager $discographyManager
     */
    public function __construct(Router $router, DiscographyManager $discographyManager)
    {
        $this->router = $router;
        $this->discographyManager = $discographyManager;
    }

    /**
     * @param GenerateEvent $event
     */
    public function onGenerateSitemapEvent(GenerateEvent $event)
    {
        // Add main url
        $mainUrl = [
            'loc'        => $this->router->generate('discography'),
            'changefreq' => 'weekly',
            'priority'   => '0.80',
        ];
        $event->addUrls($mainUrl);

        // Add some urls of discography
        foreach ($this->discographyManager->getPublicAlbums() as $album) {

            if (!$album->getUrl()) {
                continue;
            }

            $urlAlbum = $this->router->generate(
                'discography_album_show_rewrite',
                ['url_key' => $album->getUrl()->getUrlKey()]
            );
            if (empty($urlAlbum)) {
                $urlAlbum = $this->router->generate('discography_album_show', ['id' => $album->getId()]);
            }

            $urlAlbumDiscography = [
                'loc'        => $urlAlbum,
                'changefreq' => 'weekly',
                'priority'   => '0.50',
            ];
            $event->addUrls($urlAlbumDiscography);
        }
    }
}
