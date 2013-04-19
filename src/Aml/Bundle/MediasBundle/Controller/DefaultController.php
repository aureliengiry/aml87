<?php

namespace Aml\Bundle\MediasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AmlMediasBundle:Default:index.html.twig', array('name' => $name));
    }
}
