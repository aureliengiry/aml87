<?php
namespace Aml\Bundle\EvenementsBundle\EventListener;

use Aml\Bundle\WebBundle\Event\Sitemap\GenerateEvent;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Router;

/**
 * Class PostListener
 * @package Aml\Bundle\EvenementsBundle\EventListener
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
        // add main url
        $mainUrl = array('loc' => $this->router->generate('agenda'), 'changefreq' => 'weekly', 'priority' => '0.80');
        $event->addUrls($mainUrl);

        // add some urls fo agenda events
        $evenementRepository = $this->em->getRepository('AmlEvenementsBundle:Evenement');
        $agendaEvents = $evenementRepository->getNextEvenements(
            array(
                'public'  => 1,
                'archive' => 0,
                'type'    => \Aml\Bundle\EvenementsBundle\Entity\Evenement::EVENEMENT_TYPE_CONCERT,
            )
        );

        foreach ($agendaEvents as $agendaEvent) {

            if (!$agendaEvent->getUrl()) {
                continue;
            }

            $urlEvent = $this->router->generate(
                'agenda_show_event_rewrite',
                array('url_key' => $agendaEvent->getUrl()->getUrlKey())
            );
            if (empty($urlEvent)) {
                $urlEvent = $this->router->generate('agenda_show_event', array('id' => $agendaEvent->getId()));
            }

            $urlEventAgenda = array('loc' => $urlEvent, 'changefreq' => 'weekly', 'priority' => '0.50');
            $event->addUrls($urlEventAgenda);
        }
    }
}
