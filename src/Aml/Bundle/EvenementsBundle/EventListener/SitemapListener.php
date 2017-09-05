<?php
namespace Aml\Bundle\EvenementsBundle\EventListener;

use Aml\Bundle\EvenementsBundle\Entity\Evenement;
use Aml\Bundle\WebBundle\Event\Sitemap\GenerateEvent;
use Doctrine\ORM\EntityManagerInterface;
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
     * @param EntityManagerInterface $entityManager
     * @param Router $router
     */
    public function __construct(EntityManagerInterface $entityManager, Router $router)
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
        $mainUrl = [
            'loc'        => $this->router->generate('agenda'),
            'changefreq' => 'weekly',
            'priority'   => '0.80',
        ];
        $event->addUrls($mainUrl);

        // add some urls fo agenda events
        $evenementRepository = $this->em->getRepository(Evenement::class);
        $agendaEvents = $evenementRepository->getNextEvenements(
            [
                'public'  => 1,
                'archive' => 0,
                'type'    => Evenement::EVENEMENT_TYPE_CONCERT,
            ]
        );

        foreach ($agendaEvents as $agendaEvent) {

            if (!$agendaEvent->getUrl()) {
                continue;
            }

            $urlEventAgenda = [
                'loc'        => $this->router->generate('agenda_show_event', ['slug' => $agendaEvent->getSlug()]),
                'changefreq' => 'weekly',
                'priority'   => '0.50',
            ];
            $event->addUrls($urlEventAgenda);
        }
    }
}
