<?php

declare(strict_types=1);

/**
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>.
 */

namespace App\Controller\MembersArea;

use App\Agenda\Agenda;
use App\Agenda\SeasonManager;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Members controller.
 */
#[Route(path: '/espace-membres')]
#[IsGranted('ROLE_USER')]
final class MembersController extends AbstractController
{
    public function __construct(private readonly Agenda $agenda, private readonly SeasonManager $seasonManager)
    {
    }

    /**
     * dashboard entities.
     */
    #[Route(path: '/', name: 'app_members_area', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('members/index.html.twig');
    }

    /**
     * Lists all User entities.
     */
    #[Route(path: '/list', name: 'aml_users_members_list', methods: ['GET'])]
    public function list(): Response
    {
        return $this->render('members/list.html.twig', [
            'users' => $this->getDoctrine()->getManager()->getRepository(User::class)->findAll(),
        ]);
    }

    /**
     * Display agenda.
     */
    #[Route(path: '/agenda', name: 'app_members_agenda', methods: ['GET'])]
    public function agenda(): Response
    {
        $currentSeason = $this->seasonManager->getCurrentSeason();

        return $this->render('members/agenda.html.twig', [
            'current_season' => $currentSeason,
            'agenda_events' => $this->agenda->getAllEventsBySeason($currentSeason),
        ]);
    }
}
