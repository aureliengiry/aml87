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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Blog controller.
 *
 * @Route("/agenda")
 */
class AgendaController extends AbstractController
{
    /** @var Agenda */
    private $agenda;

    /** @var SeasonManager */
    private $seasonManager;

    /** @var MenuItem */
    private $appMainMenu;

    public function __construct(
        Agenda $agenda,
        SeasonManager $seasonManager,
        MenuItem $appMainMenu
    ) {
        $this->agenda = $agenda;
        $this->seasonManager = $seasonManager;
        $this->appMainMenu = $appMainMenu;
    }

    /**
     * Lists all Blog entities.
     *
     * @Route("/", name="agenda", methods={"GET"})
     * @Template("agenda/index.html.twig")
     */
    public function index(): array
    {
        $currentSeason = $this->seasonManager->getCurrentSeason();

        return [
            'current_season' => $currentSeason,
            'entities' => $this->agenda->getPublicEventsBySeason($currentSeason),
            'seasons' => $this->seasonManager->getPastSeasons(),
        ];
    }

    /**
     * Finds and displays a Evenement entity.
     *
     * @Route(
     *     "/evenement/{slug}.html",
     *     name="agenda_show_event",
     *     methods={"GET"}
     *     )
     * @Template("agenda/show.html.twig")
     *
     * @param int|string $slug
     */
    public function show(string $slug, Request $request): array
    {
        $event = $this->agenda->getEventByIdOrUrl($slug);
        if (!$event) {
            throw $this->createNotFoundException('Unable to find AmlWebBundle:Evenement entity.');
        }

        // Init Main Menu
        $this->appMainMenu->getChild('Agenda')->setCurrent(true);

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
            'nextConcert' => $this->agenda->getNextConcert(),
        ]);
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
     * @Template("agenda/archives.html.twig")
     */
    public function archives(int $season_id, Request $request): array
    {
        $seasonsRepository = $this->getDoctrine()->getManager()->getRepository(Season::class);

        $season = $seasonsRepository->find($season_id);
        if (!$season) {
            throw $this->createNotFoundException('Unable to find AmlWebBundle:Season entity.');
        }

        // Init Main Menu
        $this->appMainMenu->getChild('Agenda')->setCurrent(true);

        $request->attributes->set('label', $season->getName());

        return [
            'currentSeason' => $season,
            'entities' => $this->agenda->getArchivedConcertBySeason($season),
            'seasons' => $seasonsRepository->getPastSeasons(),
        ];
    }
}
