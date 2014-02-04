<?php

namespace Aml\Bundle\WebBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Aml\Bundle\WebBundle\Entity\Album;
use Aml\Bundle\WebBundle\Form\Admin\AlbumType;

/**
 * Album controller.
 *
 * @Route("/admin/content/album")
 */
class AlbumController extends Controller
{
	protected $_limitPagination = 5;
	
    /**
     * Lists all Album entities.
     *
     * @Route("/", name="content_album")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AmlWebBundle:Album')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Album entity.
     *
     * @Route("/{id}/show", name="content_album_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AmlWebBundle:Album')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Album entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Album entity.
     *
     * @Route("/new", name="content_album_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Album();
        $form   = $this->createForm(new AlbumType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Album entity.
     *
     * @Route("/create", name="content_album_create")
     * @Method("post")
     * @Template("AmlWebBundle:Album:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Album();
        $request = $this->getRequest();
        $form    = $this->createForm(new AlbumType(), $entity);
        $form->bindRequest($request);
	
       // var_dump('<pre>',$form,$entity);exit;
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('content_album'));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Album entity.
     *
     * @Route("/{id}/edit", name="content_album_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AmlWebBundle:Album')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Album entity.');
        }

        $editForm = $this->createForm(new AlbumType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Album entity.
     *
     * @Route("/{id}/update", name="content_album_update")
     * @Method("post")
     * @Template("AmlWebBundle:Album:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AmlWebBundle:Album')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Album entity.');
        }

        $editForm   = $this->createForm(new AlbumType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('content_album_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Album entity.
     *
     * @Route("/{id}/delete", name="content_album_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AmlWebBundle:Album')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Album entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('content_album'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
