<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class MediasController.
 */
class MediasController extends AbstractController
{
    public function index($name)
    {
        return $this->render('medias/index.html.twig', ['name' => $name]);
    }
}
