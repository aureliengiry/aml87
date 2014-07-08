<?php

namespace Aml\Bundle\BlogBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Aml\Bundle\BlogBundle\Entity\BlogTags;

//use Aml\Bundle\BlogBundle\Form\Admin\TagsType;

/**
 * Tags controller.
 *
 * @Route("/admin/content/tags")
 */
class TagsController extends Controller
{
    /**
     * Lists all Tags entities.
     *
     * @Route("/", name="content_tags")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AmlBlogBundle:Tags')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Tags entity.
     *
     * @Route("/{id}/show", name="content_tags_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AmlBlogBundle:Tags')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tags entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),);
    }

    /**
     * Displays a form to create a new Tags entity.
     *
     * @Route("/new", name="content_tags_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Tags();
        $form = $this->createForm(new TagsType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView()
        );
    }

    /**
     * Creates a new Tags entity.
     *
     * @Route("/create", name="content_tags_create")
     * @Method("post")
     * @Template("AmlBlogBundle:Tags:new.html.twig")
     */
    public function createAction()
    {
        $entity = new Tags();
        $request = $this->getRequest();
        $form = $this->createForm(new TagsType(), $entity);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('content_tags_show', array('id' => $entity->getId())));

        }

        return array(
            'entity' => $entity,
            'form' => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Tags entity.
     *
     * @Route("/{id}/edit", name="content_tags_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AmlBlogBundle:Tags')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tags entity.');
        }

        $editForm = $this->createForm(new TagsType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Tags entity.
     *
     * @Route("/{id}/update", name="content_tags_update")
     * @Method("post")
     * @Template("AmlBlogBundle:Tags:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AmlBlogBundle:Tags')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tags entity.');
        }

        $editForm = $this->createForm(new TagsType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('content_tags_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Tags entity.
     *
     * @Route("/{id}/delete", name="content_tags_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AmlBlogBundle:Tags')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tags entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('content_tags'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm();
    }
}
