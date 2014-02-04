<?php

namespace Aml\Bundle\WebBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Aml\Bundle\WebBundle\Entity\Link;
use Aml\Bundle\WebBundle\Form\Admin\LinkType;

/**
 * Link controller.
 *
 * @Route("/admin/content/link")
 */
class LinkController extends Controller
{
	protected $_limitPagination = 5;
	
    /**
     * Lists all Link entities.
     *
     * @Route("/", name="content_link")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AmlWebBundle:Link')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Displays a form to create a new Link entity.
     *
     * @Route("/new", name="content_link_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Link();
        $form   = $this->createForm(new LinkType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Link entity.
     *
     * @Route("/create", name="content_link_create")
     * @Method("post")
     * @Template("AmlWebBundle:Link:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Link();
        $request = $this->getRequest();
        $form    = $this->createForm(new LinkType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->setFlash('success', 'Lien créé avec succès');
            return $this->redirect($this->generateUrl('content_link'));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Link entity.
     *
     * @Route("/{id}/edit", name="content_link_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AmlWebBundle:Link')->find($id);
    
        if (!$entity) {            
            $this->get('session')->setFlash('notice', 'Ce lien n\'existe pas !');
            return $this->redirect($this->generateUrl('content_link'));
        }

        $editForm = $this->createForm(new LinkType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Link entity.
     *
     * @Route("/{id}/update", name="content_link_update")
     * @Method("post")
     * @Template("AmlWebBundle:Link:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AmlWebBundle:Link')->find($id);

        if (!$entity) {            
            $this->get('session')->setFlash('notice', 'Ce lien n\'existe pas !');
            return $this->redirect($this->generateUrl('content_link'));
        }
        

        $editForm   = $this->createForm(new LinkType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->setFlash('success', 'Les modifications ont été enregistrées.');
            return $this->redirect($this->generateUrl('content_link_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Link entity.
     *
     * @Route("/{id}/delete", name="content_link_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AmlWebBundle:Link')->find($id);
        
	        if (!$entity) {            
	            $this->get('session')->setFlash('notice', 'Ce lien n\'existe pas !');
	            return $this->redirect($this->generateUrl('content_link'));
	        }

            $em->remove($entity);
            $em->flush();
        }

        $this->get('session')->setFlash('success', 'Ce lien a été supprimé');
        return $this->redirect($this->generateUrl('content_link'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
