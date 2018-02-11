<?php

namespace Aml\Bundle\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class MediasController
 * @package Aml\Bundle\WebBundle\Controller
 */
class MediasController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('medias/index.html.twig', ['name' => $name]);
    }
}
