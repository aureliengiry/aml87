<?php

namespace Aml\Bundle\DiscographyBundle\EventListener;

use Aml\Bundle\WebBundle\Event\Sitemap\GenerateEvent;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * Class PostListener
 * @package Aml\Bundle\DiscographyBundle\EventListener
 */
class SitemapListener
{
    private $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param PostEvent $event
     */
    public function onGenerateSitemapEvent(GenerateEvent $event)
    {
        $router = $this->container->get('router');

        // Add main url
        $mainUrl = array('loc' => $router->generate('discography'), 'changefreq' => 'weekly', 'priority' => '0.80');
        $event->addUrls($mainUrl);

        // add some urls of discography
        $doctrine = $this->container->get('doctrine');
        $repo = $doctrine->getManager('default')->getRepository('AmlDiscographyBundle:Album');
        $entities = $repo->findBy(
            array('public' => "1"),
            array('date' => 'DESC')
        );

        foreach ($entities as $album) {
            $urlAlbum = $router->generate(
                'discography_album_show_rewrite',
                array('url_key' => $album->getUrl()->getUrlKey())
            );
            if (empty($urlAlbum)) {
                $urlAlbum = $router->generate('discography_album_show', array('id' => $album->getId()));
            }

            $urlAlbumDiscography = array('loc' => $urlAlbum, 'changefreq' => 'weekly', 'priority' => '0.50');
            $event->addUrls($urlAlbumDiscography);
        }
    }
}
