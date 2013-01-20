<?php

namespace Aml\Bundle\WebBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Default controller.
 *
 * @Route("/admin")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="admin") 
     * @Template()
     */
    public function indexAction()
    {
    	//$user = $this->container->get('security.context')->getToken()->getUser();
    	//var_dump( $user->getRoles() );exit;
    	
    	
        return array();
    }
    /**
     * @Route("/content", name="admin_content") 
     * @Template()
     */
    public function contentAction()
    {
        return array();
    }
}
