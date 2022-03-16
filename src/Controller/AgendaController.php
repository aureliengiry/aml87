<?php

declare(strict_types=1);

/**
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>.
 */

namespace App\Controller;

use App\Agenda\Agenda;
use App\Agenda\SeasonManager;
use App\Repository\SeasonRepository;
use Knp\Menu\MenuItem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Blog controller.
 */
#[Route(path: '/agenda')]
final class AgendaController extends AbstractController
{
    public function __construct(
        private readonly Agenda $agenda,
        private readonly SeasonManager $seasonManager,
        private readonly MenuItem $appMainMenu,
        private readonly Environment $twig,
        private readonly SeasonRepository $seasonRepository
    ) {
    }

    /**
     * Lists all Blog entities.
     */
    #[Route(path: '/', name: 'agenda', methods: ['GET'])]
    public function index(): Response
    {
        return new Response($this->twig->render(
            'agenda/index.html.twig',
            [
                'current_season' => $this->seasonManager->getCurrentSeason(),
                'entities' => $this->agenda->getPublicEventsBySeason(),
                'seasons' => $this->seasonManager->getPastSeasons(),
            ]
        ));
    }

    /**
     * Finds and displays a Evenement entity.
     */
    #[Route(path: '/evenement/{slug}.html', name: 'agenda_show_event', methods: ['GET'])]
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
     */
    #[Route(path: '/archives/{seasonId}', name: 'agenda_archives', requirements: ['seasonId' => '\d+'], methods: ['GET'])]
    public function archives(int $seasonId, Request $request): Response
    {
        $season = $this->seasonRepository->find($seasonId);
        if (null === $season) {
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
                'seasons' => $this->seasonRepository->getPastSeasons(),
            ]
        ));
    }
}
