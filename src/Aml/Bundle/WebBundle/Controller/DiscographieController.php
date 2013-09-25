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
 * @Route("/discographie")
 */
class DiscographieController extends Controller
{
    /**
     * Lists all Blog entities.
     *
     * @Route("/", name="discographie")
     * @Template()
     */
    public function indexAction()
    {
        
       	$em = $this->getDoctrine()->getManager();

       	//$entities = $em->getRepository('AmlWebBundle:Album')->findAll();
       
       	$repo = $this->getDoctrine()->getRepository('AmlWebBundle:Album');
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

        $entity = $em->getRepository('AmlWebBundle:Album')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Album entity.');
        }

       

        return array(
            'entity'      => $entity
         );
    }
    
    
}
