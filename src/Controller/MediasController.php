<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MediasController.
 */
final class MediasController extends AbstractController
{
    public function index($name): Response
    {
        return $this->render('medias/index.html.twig', ['name' => $name]);
    }
}
