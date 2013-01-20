<?php

namespace Aml\Bundle\GdataBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/tototest")
     * @Template()
     */
    public function indexAction()
    {
    	$gdata = new \Zend_Gdata_Calendar();
        return array();
    }
}
