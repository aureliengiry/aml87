<?php

namespace Aml\Bundle\UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * Lists all Blog entities.
     *
     * @Route("/list", name="aml_users_members_list")
     * @Template()
     */
    public function listAction()
    {

        $doctine = $this->getDoctrine();
        $em = $doctine->getManager();

        $users = $em->getRepository('AmlUsersBundle:User')->findAll();


        return array(
            'users' => $users
        );
    }
}
