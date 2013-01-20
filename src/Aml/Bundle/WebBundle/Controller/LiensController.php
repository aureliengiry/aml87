<?php

namespace Aml\Bundle\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Aml\Bundle\WebBundle\Entity\Blog;

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
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('AmlWebBundle:Link')->getPublicLinks();

        return array('entities' => $entities);
    }
    
}
