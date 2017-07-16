<?php

namespace Aml\Bundle\EvenementsBundle\Controller;

use Aml\Bundle\EvenementsBundle\Entity\Evenement;
use Aml\Bundle\EvenementsBundle\Entity\Season;
use Aml\Bundle\EvenementsBundle\Evenement\EvenementManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Blog controller.
 *
 * @Route("/agenda")
 */
class AgendaController extends Controller
{
    /**
     * Lists all Blog entities.
     *
     * @Route("/", name="agenda")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $seasonsRepository = $em->getRepository(Season::class);
        $seasons = $seasonsRepository->getPastSeasons();
        $lastSeason = $seasonsRepository->getLastSeason();

        return [
            'entities'      => $this->get(EvenementManager::class)->getPublicEventsInCurrentSeason(),
            'seasons'       => $seasons,
            'currentSeason' => $lastSeason,
        ];
    }

    /**
     * Finds and displays a Evenement entity.
     *
     * @Route("/evenement/{slug}.html", name="agenda_show_event")
     * @Template()
     *
     * @param int|string $slug
     *
     * @return array
     */
    public function showAction($slug, Request $request)
    {
        $event = $this->get(EvenementManager::class)->getEventByIdOrUrl($slug);
        if (!$event) {
            throw $this->createNotFoundException('Unable to find AmlEvenementsBundle:Evenement entity.');
        }

        // Init Main Menu
        $menu = $this->get("app.main_menu");
        $menu->getChild("Agenda")->setCurrent(true);

        $request->attributes->set('label', $event->getTitle());

        return ['entity' => $event];
    }

    /**
     * Action for Next Concert Block
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function nextConcertAction()
    {
        // getNextConcert
        $repo = $this->getDoctrine()->getRepository(Evenement::class);
        $nextConcert = $repo->getNextConcert();

        return $this->render(
            'AmlEvenementsBundle::Blocs/blocNextConcert.html.twig',
            array('nextConcert' => $nextConcert)
        );
    }

    /**
     * Lists all archived event.
     *
     * @Route("/archives/{season_id}", name="agenda_archives")
     * @Template()
     */
    public function archivesAction($season_id = false, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $seasonsRepository = $em->getRepository(Season::class);
        $evenementRepository = $em->getRepository(Evenement::class);
        if ($season_id) {
            $season = $seasonsRepository->find($season_id);
        } else {
            $season = $seasonsRepository->getLastSeason();
        }

        if (!$season) {
            throw $this->createNotFoundException('Unable to find AmlEvenementsBundle:Season entity.');
        }

        // Init Main Menu
        $menu = $this->get("app.main_menu");
        $menu->getChild("Agenda")->setCurrent(true);

        $request->attributes->set('label', $season->getName());

        $events = $evenementRepository->getArchivedConcertBySeason($season);
        $seasons = $seasonsRepository->getPastSeasons();

        return [
            'currentSeason' => $season,
            'entities'      => $events,
            'seasons'       => $seasons,
        ];
    }
}
