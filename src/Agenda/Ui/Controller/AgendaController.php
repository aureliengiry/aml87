<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Agenda\Ui\Controller;

use App\Agenda\Domain\EvenementRepositoryInterface;
use App\Agenda\Domain\Exception\EventNotFoundException;
use App\Agenda\Domain\Model\Season;
use App\Agenda\Domain\SeasonManager;
use App\Core\Infrastructure\Adapter\Doctrine\EventAgendaDoctrineAdapter;
use Knp\Menu\MenuItem;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Agenda controller.
 *
 * @Route("/agenda")
 */
class AgendaController extends AbstractController
{
    /** @var SeasonManager */
    private $seasonManager;

    /** @var MenuItem */
    private $appMainMenu;

    /** @var EvenementRepositoryInterface */
    private $obtainAgendaEvents;

    public function __construct(
        SeasonManager $seasonManager,
        MenuItem $appMainMenu,
        EventAgendaDoctrineAdapter $eventAgendaDoctrineAdapter
    ) {
        $this->seasonManager = $seasonManager;
        $this->appMainMenu = $appMainMenu;
        $this->obtainAgendaEvents = $eventAgendaDoctrineAdapter;
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
            'agenda_events' => $this->obtainAgendaEvents->getPublicEventsBySeason($currentSeason),
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
    public function show(Request $request, string $slug): array
    {
        try {
            $event = $this->obtainAgendaEvents->getEventBySlug($slug);

            // Init Main Menu
            $this->appMainMenu->getChild('Agenda')->setCurrent(true);
            $request->attributes->set('label', $event->getTitle());
        } catch (EventNotFoundException $eventNotFoundException) {
            throw $this->createNotFoundException('Unable to find AmlWebBundle:Evenement entity.');
        }

        return ['event' => $event];
    }

    /**
     * Action for Next Concert Block.
     */
    public function nextConcert(): Response
    {
        return $this->render(
            'agenda/blocs/bloc_next_concert.html.twig', [
            'nextConcert' => $this->obtainAgendaEvents->getNextConcert(),
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
            'agenda_events' => $this->obtainAgendaEvents->getArchivedConcertBySeason($season),
            'seasons' => $seasonsRepository->getPastSeasons(),
        ];
    }
}
