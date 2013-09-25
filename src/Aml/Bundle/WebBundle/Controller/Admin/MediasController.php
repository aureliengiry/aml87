<?php

namespace Aml\Bundle\WebBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

// Entities
use Aml\Bundle\WebBundle\Entity\File;
use Aml\Bundle\WebBundle\Entity\Image;
use Aml\Bundle\WebBundle\Entity\Music;

// Forms
use Aml\Bundle\WebBundle\Form\Admin\FileType;


/**
 * File controller.
 *
 * @Route("/admin/medias")
 */
class MediasController extends Controller
{
	protected $_limitPagination = 5;
	
    /**
     * Lists all File entities.
     *
     * @Route("/", name="admin_medias")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AmlWebBundle:File')->findAll();
        
        $deleteForms = array();
        foreach($entities as $file){
        	$deleteForms[$file->getId()] = $this->createDeleteForm($file->getId())->createView();
        }
      

        return array('entities' => $entities,'delete_forms' => $deleteForms);
    }

    /**
     * Finds and displays a File entity.
     *
     * @Route("/{id}/show", name="admin_file_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AmlWebBundle:File')->find($id);

        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find File entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new File entity.
     *
     * @Route("/new/{type}", name="admin_file_new")
     * @Template()
     */
    public function newAction($type)
    {
    	if( 'file' == $type ){
    		$entity = new File();
    	}
    	elseif ( 'image' === $type ){
    		$entity = new Image();
    	}
    	elseif ( 'music' === $type ){
    		$entity = new Music();
    	}
    
      	$form   = $this->createForm(new FileType(),$entity);


        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        	'type' 	=> $type
         );
    }

    /**
     * Creates a new File entity.
     *
     * @Route("/create/{type}", name="admin_file_create")
     * @Method("post")
     * @Template("AmlWebBundle:Admin/Medias:new.html.twig")
     */
    public function createAction($type)
    {
    	
    	if( 'file' === $type ){
    		$entity = new File();
    	}
    	elseif ( 'image' === $type ){
    		$entity = new Image();
    	}
    	elseif ( 'music' === $type ){
    		$entity = new Music();
    	}
//     	else{
    		//$entity = new File();
    	//}
    	
    	var_dump( get_class($entity));
        $request = $this->getRequest();
        $form    = $this->createForm(new FileType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
          //  $entity->upload();
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('success', 'Document ajouté avec succès');
            return $this->redirect($this->generateUrl('admin_medias'));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        	'type'	=> $type
        );
    }

    /**
     * Displays a form to edit an existing File entity.
     *
     * @Route("/{id}/edit", name="admin_file_edit")
     * @Template()
     */
    public function editAction($id)
    {
    	
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AmlWebBundle:File')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find File entity.');
        }

        $editForm = $this->createForm(new FileType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing File entity.
     *
     * @Route("/{id}/update", name="admin_file_update")
     * @Method("post")
     * @Template("AmlWebBundle:File:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AmlWebBundle:File')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find File entity.');
        }

        $editForm   = $this->createForm(new FileType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
        	$entity->removeUpload();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_file_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a File entity.
     *
     * @Route("/{id}/delete", name="admin_file_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AmlWebBundle:File')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find File entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_medias'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
