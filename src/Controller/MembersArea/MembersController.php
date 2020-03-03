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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Members controller.
 *
 * @Route("/espace-membres")
 * @Security("has_role('ROLE_USER')")
 */
class MembersController extends AbstractController
{
    /** @var Agenda */
    private $agenda;

    /** @var SeasonManager */
    private $seasonManager;

    public function __construct(Agenda $agenda, SeasonManager $seasonManager)
    {
        $this->agenda = $agenda;
        $this->seasonManager = $seasonManager;
    }

    /**
     * dashboard entities.
     *
     * @Route("/", name="app_members_area", methods={"GET"})
     * @Template("members/index.html.twig")
     */
    public function index()
    {
        return [];
    }

    /**
     * Lists all User entities.
     *
     * @Route("/list", name="aml_users_members_list", methods={"GET"})
     * @Template("members/list.html.twig")
     */
    public function list()
    {
        return [
            'users' => $this->getDoctrine()->getManager()->getRepository(User::class)->findAll(),
        ];
    }

    /**
     * Display agenda.
     *
     * @Route("/agenda", name="app_members_agenda", methods={"GET"})
     * @Template("members/agenda.html.twig")
     */
    public function agenda()
    {
        $currentSeason = $this->seasonManager->getCurrentSeason();

        return [
            'current_season' => $currentSeason,
            'agenda_events' => $this->agenda->getAllEventsBySeason($currentSeason),
        ];
    }
}
