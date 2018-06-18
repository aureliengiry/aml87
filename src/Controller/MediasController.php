<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class MediasController
 * @package App\Controller
 */
class MediasController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('medias/index.html.twig', ['name' => $name]);
    }
}
