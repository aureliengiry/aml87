<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Core\Ui\Controller\MembersArea;

use App\Core\Ui\Form\Type\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SecurityController.
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion", name="app_members_area_login", methods={"GET"})
     */
    public function login(Request $request): Response
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        $form = $this->get('form.factory')->createNamed('', LoginType::class, [
            '_login_email' => $authenticationUtils->getLastUsername(),
        ]);

        return $this->render('security/login.html.twig', [
            'error' => $authenticationUtils->getLastAuthenticationError(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/connexion/check", name="app_members_area_login_check", methods={"POST"})
     */
    public function loginCheck()
    {
    }

    /**
     * @Route("/deconnexion", name="app_members_area_logout", methods={"GET"})
     */
    public function logout()
    {
    }
}
