<?php

declare(strict_types=1);

/**
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class MediasController extends AbstractController
{
    public function index($name, Environment $twig): Response
    {
        return new Response(
            $twig->render('medias/index.html.twig', ['name' => $name])
        );
    }
}
