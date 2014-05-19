<?php

namespace Aml\Bundle\DiscographyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class DefaultController
 * @package Aml\Bundle\DiscographyBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * Lists all Album entities.
     *
     * @Route("/", name="discographie")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $repo = $this->getDoctrine()->getRepository('AmlDiscographyBundle:Album');
        $entities = $repo->findBy(
            array('public' => "1"),
            array('date' => 'DESC')

        );

        return array('entities' => $entities);
    }


    /**
     * Finds and displays a Album entity.
     *
     * @Route("/{id}", name="discographie_album")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AmlDiscographyBundle:Album')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Album entity.');
        }

        return array(
            'entity'      => $entity
        );
    }


}
