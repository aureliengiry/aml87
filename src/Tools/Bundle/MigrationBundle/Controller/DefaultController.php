<?php

namespace Tools\Bundle\MigrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ToolsMigrationBundle:Default:index.html.twig', array('name' => $name));
    }
}
