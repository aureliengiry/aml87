<?php

namespace App\Controller\MembersArea;

use App\Form\Type\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class SecurityController
 * @package App\Controller\MembersArea
 */
class SecurityController extends Controller
{
    /**
     * @Route("/connexion", name="app_members_area_login")
     * @Method("GET")
     */
    public function login(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        $form = $this->get('form.factory')->createNamed('', LoginType::class, [
            '_login_email' => $authenticationUtils->getLastUsername(),
        ]);

        return $this->render('security/login.html.twig', array(
            'error'         => $authenticationUtils->getLastAuthenticationError(),
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/connexion/check", name="app_members_area_login_check")
     * @Method("POST")
     */
    public function loginCheck()
    {
    }

    /**
     * @Route("/deconnexion", name="app_members_area_logout")
     * @Method("GET")
     */
    public function logout()
    {
    }
}
