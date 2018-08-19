<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class MediasController.
 */
class MediasController extends Controller
{
    public function index($name)
    {
        return $this->render('medias/index.html.twig', ['name' => $name]);
    }
}
