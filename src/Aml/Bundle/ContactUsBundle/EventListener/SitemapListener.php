<?php
namespace Aml\Bundle\ContactUsBundle\EventListener;

use Aml\Bundle\WebBundle\Event\Sitemap\GenerateEvent;
use Symfony\Component\Routing\Router;

/**
 * Class PostListener
 * @package Aml\Bundle\ContactUsBundle\EventListener
 */
class SitemapListener
{
    private $router;

    /**
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @param GenerateEvent $event
     */
    public function onGenerateSitemapEvent(GenerateEvent $event)
    {
        // Add main url
        $mainUrl = [
            'loc'        => $this->router->generate('aml_contactus_default_index'),
            'changefreq' => 'weekly',
            'priority'   => '0.80',
        ];
        $event->addUrls($mainUrl);
    }
}
