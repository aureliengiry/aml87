<?php

declare(strict_types=1);

/**
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>.
 */

namespace App\Controller;

use App\Entity\Link;
use App\Repository\LinkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

#[Route(path: '/liens')]
final class LiensController extends AbstractController
{
    /**
     * Lists all link entities.
     */
    #[Route(path: '/', name: 'liens', methods: ['GET'])]
    public function index(Environment $twig, LinkRepository $linkRepository): Response
    {
        return new Response($twig->render('liens/index.html.twig', [
            'entities' => $linkRepository->getPublicLinks(),
        ]));
    }
}
