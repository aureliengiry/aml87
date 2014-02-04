<?php

namespace Aml\Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class DefaultController extends Controller
{

    public function indexAction()
    {
        //$user = $this->container->get('security.context')->getToken()->getUser();
        //var_dump( $user->getRoles() );exit;
        return $this->render('AmlAdminBundle:Default:index.html.twig');

    }
}
