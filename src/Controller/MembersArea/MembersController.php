<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Controller\MembersArea;

use App\Agenda\Agenda;
use App\Agenda\SeasonManager;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Members controller.
 *
 * @Route("/espace-membres")
 * @Security("has_role('ROLE_USER')")
 */
final class MembersController extends AbstractController
{
    private Agenda $agenda;
    private SeasonManager $seasonManager;

    public function __construct(Agenda $agenda, SeasonManager $seasonManager)
    {
        $this->agenda = $agenda;
        $this->seasonManager = $seasonManager;
    }

    /**
     * dashboard entities.
     *
     * @Route("/", name="app_members_area", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('members/index.html.twig');
    }

    /**
     * Lists all User entities.
     *
     * @Route("/list", name="aml_users_members_list", methods={"GET"})
     */
    public function list(): Response
    {
        return $this->render('members/list.html.twig', [
            'users' => $this->getDoctrine()->getManager()->getRepository(User::class)->findAll(),
        ]);
    }

    /**
     * Display agenda.
     *
     * @Route("/agenda", name="app_members_agenda", methods={"GET"})
     */
    public function agenda(): Response
    {
        $currentSeason = $this->seasonManager->getCurrentSeason();

        return $this->render('members/agenda.html.twig', [
            'current_season' => $currentSeason,
            'agenda_events' => $this->agenda->getAllEventsBySeason($currentSeason),
        ]);
    }
}
