<?php

namespace Aml\Bundle\WebBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Aml\Bundle\WebBundle\Entity\Blog;
use Aml\Bundle\WebBundle\Form\Admin\BlogType;

/**
 * Blog controller.
 *
 * @Route("/admin/content/blog")
 */
class BlogController extends Controller
{
	protected $_limitPagination = 5;
	
    /**
     * Lists all Blog entities.
     *
     * @Route("/{page}", name="admin_content_blog", requirements={"page" = "\d+"}, defaults={"page" = 1})
     * @Template()
     */
    public function indexAction($page)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repositoryBlog = $em->getRepository('AmlWebBundle:Blog');
        	
        $allEntities = $repositoryBlog->findAll();
        $nbEntities = count($allEntities);
        $num_pages = $page; // some calculation of what page you're currently on
		
		
		$entities = $repositoryBlog->findBy(
		    array('public' => "1"),
		    array('created' => 'DESC'),
		    $this->_limitPagination,
		    $this->_limitPagination * ($num_pages-1)		    
		);
		
		
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
        	'pagination' => $pagination
        );
    }

    /**
     * Displays a form to create a new Blog entity.
     *
     * @Route("/new", name="admin_content_blog_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Blog();
        $form   = $this->createForm(new BlogType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Blog entity.
     *
     * @Route("/create", name="admin_content_blog_create")
     * @Method("post")
     * @Template("AmlWebBundle:Blog:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Blog();
        $request = $this->getRequest();
        $form    = $this->createForm(new BlogType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity
            	->setCreated(new \DateTime())
            	->setUpdated(new \DateTime())
            	->setPublished(new \DateTime())
            	->setUrl()
            	->setIdCategoryBlog(1)
            ;
            $em->persist($entity);
            $em->flush();

            $this->get('session')->setFlash('success', 'L\'article a été créé avec succès');
            return $this->redirect($this->generateUrl('admin_content_blog'));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Blog entity.
     *
     * @Route("/{id}/edit", name="admin_content_blog_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AmlWebBundle:Blog')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Blog entity.');
        }

        $editForm = $this->createForm(new BlogType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Blog entity.
     *
     * @Route("/{id}/update", name="admin_content_blog_update")
     * @Method("post")
     * @Template("AmlWebBundle:Blog:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AmlWebBundle:Blog')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Blog entity.');
        }

        $editForm   = $this->createForm(new BlogType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
        	$entity
        		->setUpdated(new \DateTime())
        		->setUrl()
        	;
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_content_blog_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Blog entity.
     *
     * @Route("/{id}/delete", name="admin_content_blog_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AmlWebBundle:Blog')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Blog entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('content_blog'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
