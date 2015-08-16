<?php

namespace Tools\Bundle\YoutubeApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ToolsYoutubeApiBundle:Default:index.html.twig', array('name' => $name));
    }
}
