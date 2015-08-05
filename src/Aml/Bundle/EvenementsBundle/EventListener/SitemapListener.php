<?php
namespace Aml\Bundle\EvenementsBundle\EventListener;

use Aml\Bundle\WebBundle\Event\Sitemap\GenerateEvent;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * Class PostListener
 * @package Aml\Bundle\EvenementsBundle\EventListener
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

        // add main url
        $mainUrl = array('loc' => $router->generate('agenda'), 'changefreq' => 'weekly', 'priority' => '0.80');
        $event->addUrls($mainUrl);

        // add some urls fo agenda events
        $doctrine = $this->container->get('doctrine');

        $evenementRepository = $doctrine->getManager('default')->getRepository('AmlEvenementsBundle:Evenement');
        $agendaEvents = $evenementRepository->getNextEvenements(
            array(
                'public' => 1,
                'archive' => 0,
                'type' => \Aml\Bundle\EvenementsBundle\Entity\Evenement::EVENEMENT_TYPE_CONCERT
            )
        );

        foreach ($agendaEvents as $agendaEvent) {

            if (!$agendaEvent->getUrl()) {
                continue;
            }

            $urlEvent = $router->generate(
                'agenda_show_event_rewrite',
                array('url_key' => $agendaEvent->getUrl()->getUrlKey())
            );
            if (empty($urlEvent)) {
                $urlEvent = $router->generate('agenda_show_event', array('id' => $agendaEvent->getId()));
            }

            $urlEventAgenda = array('loc' => $urlEvent, 'changefreq' => 'weekly', 'priority' => '0.50');
            $event->addUrls($urlEventAgenda);
        }
    }
}
