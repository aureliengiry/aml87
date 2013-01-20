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
 * @Route("/agenda")
 */
class AgendaController extends Controller
{
    /**
     * Lists all Blog entities.
     *
     * @Route("/", name="agenda")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('AmlWebBundle:Evenement')->findAll();

        return array('entities' => $entities);
    }
    
}
