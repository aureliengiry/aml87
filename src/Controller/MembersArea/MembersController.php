<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Controller\MembersArea;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Members controller.
 *
 * @Route("/espace-membres")
 * @Security("has_role('ROLE_USER')")
 */
class MembersController extends AbstractController
{
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
}
