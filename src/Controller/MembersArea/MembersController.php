<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Controller\MembersArea;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Members controller.
 *
 * @Route("/espace-membres")
 * @Security("has_role('ROLE_USER')")
 */
class MembersController extends Controller
{
    /**
     * Lists all Blog entities.
     *
     * @Route("/", name="app_members_area")
     * @Template("members/index.html.twig")
     * @Method("GET")
     */
    public function index()
    {
        return [];
    }

    /**
     * Lists all Blog entities.
     *
     * @Route("/list", name="aml_users_members_list")
     * @Template("members/list.html.twig")
     * @Method("GET")
     */
    public function list()
    {
        $doctine = $this->getDoctrine();
        $em = $doctine->getManager();

        return [
            'users' => $em->getRepository(User::class)->findAll(),
        ];
    }
}
