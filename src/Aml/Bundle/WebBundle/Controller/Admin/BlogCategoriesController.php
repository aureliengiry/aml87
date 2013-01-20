<?php

namespace Aml\Bundle\WebBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Aml\Bundle\WebBundle\Entity\BlogCategories;
use Aml\Bundle\WebBundle\Form\Admin\BlogCategoriesType;

/**
 * BlogCategories controller.
 *
 * @Route("/admin/content/blog/categories")
 */
class BlogCategoriesController extends Controller
{
    /**
     * Lists all BlogCategories entities.
     *
     * @Route("/", name="admin_content_blog_categories")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('AmlWebBundle:BlogCategories')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a BlogCategories entity.
     *
     * @Route("/{id}/show", name="admin_content_blog_categories_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AmlWebBundle:BlogCategories')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BlogCategories entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new BlogCategories entity.
     *
     * @Route("/new", name="admin_content_blog_categories_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new BlogCategories();
        $form   = $this->createForm(new BlogCategoriesType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new BlogCategories entity.
     *
     * @Route("/create", name="admin_content_blog_categories_create")
     * @Method("post")
     * @Template("AmlWebBundle:BlogCategories:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new BlogCategories();
        $request = $this->getRequest();
        $form    = $this->createForm(new BlogCategoriesType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_content_blog_categories_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing BlogCategories entity.
     *
     * @Route("/{id}/edit", name="admin_content_blog_categories_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AmlWebBundle:BlogCategories')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BlogCategories entity.');
        }

        $editForm = $this->createForm(new BlogCategoriesType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing BlogCategories entity.
     *
     * @Route("/{id}/update", name="admin_content_blog_categories_update")
     * @Method("post")
     * @Template("AmlWebBundle:BlogCategories:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AmlWebBundle:BlogCategories')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BlogCategories entity.');
        }

        $editForm   = $this->createForm(new BlogCategoriesType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_content_blog_categories_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a BlogCategories entity.
     *
     * @Route("/{id}/delete", name="admin_content_blog_categories_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AmlWebBundle:BlogCategories')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find BlogCategories entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_content_blog_categories'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
