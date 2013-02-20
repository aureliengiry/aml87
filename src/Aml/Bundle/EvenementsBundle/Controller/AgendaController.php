<?php

namespace Aml\Bundle\EvenementsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Aml\Bundle\BlogBundle\Entity\Blog;

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
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AmlEvenementsBundle:Evenement')->findAll();

        return array('entities' => $entities);
    }
    
}
