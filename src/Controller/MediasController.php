<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class MediasController.
 */
class MediasController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('medias/index.html.twig', ['name' => $name]);
    }
}
