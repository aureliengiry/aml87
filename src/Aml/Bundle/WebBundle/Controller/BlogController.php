<?php

namespace Aml\Bundle\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Aml\Bundle\WebBundle\Entity\Blog;
use Symfony\Component\HttpFoundation\Request;

/**
 * Blog controller.
 *
 * @Route("/blog")
 */
class BlogController extends Controller
{
	protected $_limitPagination = 5;
	
    /**
     * Lists all Blog entities.
     *
     * @Route("/{page}", name="blog",requirements={"page" = "\d+"}, defaults={"page" = 1})
     * @Template()
     */
    public function indexAction(Request $request, $page)
    {
    	$categories = $tags = array();
        $em = $this->getDoctrine()->getEntityManager();

        $nbEntities = $em->getRepository('AmlWebBundle:Blog')->countPublicArticles();
           
        $num_pages = $page; // some calculation of what page you're currently on
		$repo = $this->getDoctrine()
		                ->getRepository('AmlWebBundle:Blog');
		$entities = $repo->findBy(
		    array('public' => "1"),
		    array('created' => 'DESC'),
		    $this->_limitPagination,
		    $this->_limitPagination * ($num_pages-1)		    
		);
		
		// Get Liste catégories 
		$categories = $em->getRepository('AmlWebBundle:BlogCategories')->findAll();
		
		// Get Liste tags 
		$tags = $em->getRepository('AmlWebBundle:BlogTags')->findAll();
		
		// Calcul de la pagination
		$calculLastPage = round($nbEntities/$this->_limitPagination);
		$pagination = array(
	        	'nbEntities' => $nbEntities,
	        	'limit' => $this->_limitPagination,
	        	'currentPage' => $page,
	        	'nextPage' => ( $page+1 * $this->_limitPagination < $nbEntities ? $page+1 : false),
	        	'prevPage' => ( $page-1 > 0 ? $page-1 : false ),
				'lastPage' => ( $calculLastPage >= 0 ? $calculLastPage : 0)
        	);
 
        return array(
        	'entities' => $entities,
        	'pagination' => $pagination,
        	'categories' => $categories,
        	'tags' => $tags
        );
    }

    /**
     * Finds and displays a Blog entity.
     *
     * @Route("/id/{id}", name="blog_show")
     * @Route("/article/{url_key}.html", name="blog_show_rewrite")
     * @Template()
     */
    public function showAction($id = false, $url_key = null)
    {
        $em = $this->getDoctrine()->getEntityManager();

        if( false === $id ){
        	$entity = $em->getRepository('AmlWebBundle:Blog')->findOneBy(array('url' => $url_key));        	
        }
        else{
        	$entity = $em->getRepository('AmlWebBundle:Blog')->find($id);
        }

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AmlWebBundle:Blog entity.');
        }

        return array(
            'entity'      => $entity        );
    }

    
}
