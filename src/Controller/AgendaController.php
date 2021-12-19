<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Controller;

use App\Agenda\Agenda;
use App\Agenda\SeasonManager;
use App\Entity\Season;
use Knp\Menu\MenuItem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Blog controller.
 *
 * @Route("/agenda")
 */
final class AgendaController extends AbstractController
{
    private Agenda $agenda;
    private SeasonManager $seasonManager;
    private MenuItem $appMainMenu;
    private Environment $twig;

    public function __construct(
        Agenda $agenda,
        SeasonManager $seasonManager,
        MenuItem $appMainMenu,
        Environment $twig
    ) {
        $this->agenda = $agenda;
        $this->seasonManager = $seasonManager;
        $this->appMainMenu = $appMainMenu;
        $this->twig = $twig;
    }

    /**
     * Lists all Blog entities.
     *
     * @Route("/", name="agenda", methods={"GET"})
     */
    public function index(): Response
    {
        $currentSeason = $this->seasonManager->getCurrentSeason();

        return new Response($this->twig->render(
            'agenda/index.html.twig',
            [
                'current_season' => $currentSeason,
                'entities' => $this->agenda->getPublicEventsBySeason($currentSeason),
                'seasons' => $this->seasonManager->getPastSeasons(),
            ]
        ));
    }

    /**
     * Finds and displays a Evenement entity.
     *
     * @Route(
     *     "/evenement/{slug}.html",
     *     name="agenda_show_event",
     *     methods={"GET"}
     *     )
     */
    public function show(string $slug, Request $request): Response
    {
        $event = $this->agenda->getEventByIdOrUrl($slug);
        if ( ! $event) {
            throw $this->createNotFoundException('Unable to find Evenement entity.');
        }

        // Init Main Menu
        $this->appMainMenu->getChild('Agenda')->setCurrent(true);

        $request->attributes->set('label', $event->getTitle());

        return new Response(
            $this->twig->render('agenda/show.html.twig', ['entity' => $event])
        );
    }

    public function nextConcert(): Response
    {
        return new Response($this->twig->render(
            'agenda/blocs/bloc_next_concert.html.twig',
            [
                'nextConcert' => $this->agenda->getNextConcert(),
            ]
        ));
    }

    /**
     * Lists all archived event.
     *
     * @Route(
     *     "/archives/{season_id}",
     *     name="agenda_archives",
     *     requirements={"season_id"="\d+"},
     *     methods={"GET"}
     *     )
     */
    public function archives(int $season_id, Request $request): Response
    {
        $seasonsRepository = $this->getDoctrine()->getManager()->getRepository(Season::class);

        $season = $seasonsRepository->find($season_id);
        if ( ! $season) {
            throw $this->createNotFoundException('Unable to find Season entity.');
        }

        // Init Main Menu
        $this->appMainMenu->getChild('Agenda')->setCurrent(true);

        $request->attributes->set('label', $season->getName());

        return new Response($this->twig->render(
            'agenda/archives.html.twig',
            [
                'currentSeason' => $season,
                'entities' => $this->agenda->getArchivedConcertBySeason($season),
                'seasons' => $seasonsRepository->getPastSeasons(),
            ]
        ));
    }
}
