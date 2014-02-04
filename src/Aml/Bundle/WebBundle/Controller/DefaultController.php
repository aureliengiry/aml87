<?php

namespace Aml\Bundle\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
   /**
     * @Route("/", name="home")
     * @Template()
     */
    public function indexAction()
    {
    	// Dernier article de blog
    	$repo = $this->getDoctrine()->getRepository('AmlBlogBundle:Article');
		$blogEntity = $repo->findOneBy(
		    array('public' => "1"),
		    array('created' => 'DESC')
		 );
		 
		
		// Dernier Album
		$repo = $this->getDoctrine()->getRepository('AmlWebBundle:Album');
		$albumEntity = $repo->findOneBy(
		    array('public' => "1"),
		    array('date' => 'DESC')
		 );
    	
		
        return array(
        	'lastBlogArticle' => $blogEntity,
        	'lastAlbum' => $albumEntity
        );
    }
}
