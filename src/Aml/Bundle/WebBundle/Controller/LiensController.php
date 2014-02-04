<?php

namespace Aml\Bundle\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Aml\Bundle\BlogBundle\Entity\Blog;

/**
 * Blog controller.
 *
 * @Route("/liens")
 */
class LiensController extends Controller
{
    /**
     * Lists all Blog entities.
     *
     * @Route("/", name="liens")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AmlWebBundle:Link')->getPublicLinks();

        return array('entities' => $entities);
    }
    
}
