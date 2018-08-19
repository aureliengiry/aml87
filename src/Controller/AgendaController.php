<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Controller;

use App\Entity\Season;
use App\Evenement\EvenementManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
     * @Template("agenda/index.html.twig")
     * @Method("GET")
     */
    public function index(): array
    {
        $em = $this->getDoctrine()->getManager();

        $seasonsRepository = $em->getRepository(Season::class);
        $seasons = $seasonsRepository->getPastSeasons();

        return [
            'entities' => $this->get(EvenementManager::class)->getPublicEventsInCurrentSeason(),
            'seasons' => $seasons,
        ];
    }

    /**
     * Finds and displays a Evenement entity.
     *
     * @Route(
     *     "/evenement/{slug}.html",
     *     name="agenda_show_event"
     *     )
     * @Template("agenda/show.html.twig")
     * @Method("GET")
     *
     * @param int|string $slug
     */
    public function show(string $slug, Request $request): array
    {
        $event = $this->get(EvenementManager::class)->getEventByIdOrUrl($slug);
        if (!$event) {
            throw $this->createNotFoundException('Unable to find AmlWebBundle:Evenement entity.');
        }

        // Init Main Menu
        $menu = $this->get('app.main_menu');
        $menu->getChild('Agenda')->setCurrent(true);

        $request->attributes->set('label', $event->getTitle());

        return ['entity' => $event];
    }

    /**
     * Action for Next Concert Block.
     */
    public function nextConcert(): Response
    {
        return $this->render(
            'agenda/blocs/bloc_next_concert.html.twig', [
            'nextConcert' => $this->get(EvenementManager::class)->getNextConcert(),
        ]);
    }

    /**
     * Lists all archived event.
     *
     * @Route(
     *     "/archives/{season_id}",
     *     name="agenda_archives",
     *     requirements={"season_id"="\d+"}
     *     )
     * @Template("agenda/archives.html.twig")
     * @Method("GET")
     */
    public function archives(int $season_id, Request $request): array
    {
        $em = $this->getDoctrine()->getManager();
        $seasonsRepository = $em->getRepository(Season::class);

        $season = $seasonsRepository->find($season_id);
        if (!$season) {
            throw $this->createNotFoundException('Unable to find AmlWebBundle:Season entity.');
        }

        // Init Main Menu
        $menu = $this->get('app.main_menu');
        $menu->getChild('Agenda')->setCurrent(true);

        $request->attributes->set('label', $season->getName());

        return [
            'currentSeason' => $season,
            'entities' => $this->get(EvenementManager::class)->getArchivedConcertBySeason($season),
            'seasons' => $seasonsRepository->getPastSeasons(),
        ];
    }
}
