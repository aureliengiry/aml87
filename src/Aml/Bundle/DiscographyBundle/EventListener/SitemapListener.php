<?php

namespace Aml\Bundle\DiscographyBundle\EventListener;

use Aml\Bundle\WebBundle\Event\Sitemap\GenerateEvent;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Router;

/**
 * Class PostListener
 * @package Aml\Bundle\DiscographyBundle\EventListener
 */
class SitemapListener
{
    private $em;
    private $router;

    /**
     * @param EntityManager $entityManager
     * @param Router $router
     */
    public function __construct(EntityManager $entityManager, Router $router)
    {
        $this->em = $entityManager;
        $this->router = $router;
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

        // add some urls of discography
        $repo = $this->em->getRepository('AmlDiscographyBundle:Album');
        $entities = $repo->findBy(
            array('public' => "1"),
            array('date' => 'DESC')
        );

        foreach ($entities as $album) {

            if (!$album->getUrl()) {
                continue;
            }

            $urlAlbum = $this->router->generate(
                'discography_album_show_rewrite',
                array('url_key' => $album->getUrl()->getUrlKey())
            );
            if (empty($urlAlbum)) {
                $urlAlbum = $this->router->generate('discography_album_show', array('id' => $album->getId()));
            }

            $urlAlbumDiscography = array('loc' => $urlAlbum, 'changefreq' => 'weekly', 'priority' => '0.50');
            $event->addUrls($urlAlbumDiscography);
        }
    }
}
