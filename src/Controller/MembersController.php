<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Members controller.
 *
 * @Route("/espace-membres")
 */
class MembersController extends Controller
{
    /**
     * Lists all Blog entities.
     *
     * @Route("/", name="members-test")
     * @Template("members/index.html.twig")
     * @Method("GET")
     */
    public function indexAction()
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
    public function listAction()
    {
        $doctine = $this->getDoctrine();
        $em = $doctine->getManager();

        return [
            'users' => $em->getRepository(User::class)->findAll(),
        ];
    }
}
