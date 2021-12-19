<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Controller;

use App\Entity\Link;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route("/liens")
 */
final class LiensController extends AbstractController
{
    /**
     * Lists all link entities.
     *
     * @Route("/", name="liens", methods={"GET"})
     */
    public function index(Environment $twig): Response
    {
        return new Response($twig->render('liens/index.html.twig', [
            'entities' => $this->getDoctrine()->getManager()->getRepository(Link::class)->getPublicLinks(),
        ]));
    }
}
