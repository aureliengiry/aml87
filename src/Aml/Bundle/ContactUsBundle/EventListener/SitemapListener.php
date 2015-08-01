<?php
namespace Aml\Bundle\ContactUsBundle\EventListener;

use Aml\Bundle\WebBundle\Event\Sitemap\GenerateEvent;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * Class PostListener
 * @package Aml\Bundle\ContactUsBundle\EventListener
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
        $mainUrl = array(
            'loc'        => $router->generate('aml_contact_us_index'),
            'changefreq' => 'weekly',
            'priority'   => '0.80'
        );
        $event->addUrls($mainUrl);
    }
}
