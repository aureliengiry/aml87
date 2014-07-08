<?php

namespace Aml\Bundle\WebBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Aml\Bundle\WebBundle\Entity\Partenaire;
use Aml\Bundle\WebBundle\Form\Admin\PartenaireType;
use Aml\Bundle\MediasBundle\Entity\Image;

/**
 * Partenaire controller.
 *
 * @Route("/admin/partenaires")
 */
class PartenaireController extends Controller
{
    /**
     * Lists all Partenaire entities.
     *
     * @Route("/", name="admin_partenaire")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AmlWebBundle:Partenaire')->findAll();

        return array(
            'entities' => $entities,
        );
    }


    /**
     * Displays a form to create a new Partenaire entity.
     *
     * @Route("/new", name="admin_partenaire_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Partenaire();
        $form   = $this->createForm(new PartenaireType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Partenaire entity.
     *
     * @Route("/create", name="admin_partenaire_create")
     * @Method("POST")
     * @Template("AmlWebBundle:Admin/Partenaire:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Partenaire();
        $form = $this->createForm(new PartenaireType(), $entity);

        $form->submit($request);

        if ($form->isValid()) {

            $logo = $entity->getLogo();

            //var_dump(  '<pre>',$logo->getFile(),isset($logo) , empty($logo));exit;

            $em = $this->getDoctrine()->getManager();
            if( isset($logo) && !empty($logo) ){

                //var_dump('<pre>',$logo);


                // Set Image
                $imageEntity = $logo;
                $imageEntity
                    ->setTitle("Logo " . $entity->getName()
                );

                $entity->setLogo($imageEntity);

                $em->persist($imageEntity);
            }



            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_partenaire'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Partenaire entity.
     *
     * @Route("/{id}/edit", name="admin_partenaire_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AmlWebBundle:Partenaire')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Partenaire entity.');
        }

        $editForm = $this->createForm(new PartenaireType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Partenaire entity.
     *
     * @Route("/{id}/update", name="admin_partenaire_update")
     * @Method("POST")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AmlWebBundle:Partenaire')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Partenaire entity.');
        }

        $old_partenaire = clone $entity;

        $editForm = $this->createForm(new PartenaireType(), $entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {

            $logo = $entity->getLogo();
            var_dump(  '<pre>',get_class($logo),isset($logo) , empty($logo));exit;
            $em = $this->getDoctrine()->getManager();
            if( isset($logo) && !empty($logo) ){


                // Set Image
                $imageEntity = $logo;

                $imageEntity
                    ->setTitle("Logo " . $entity->getName()
                    );

                $entity->setLogo($imageEntity);

                $em->persist($imageEntity);
                //exit;
            }

            $em->persist($entity);
            $em->flush();


        }

        return $this->redirect($this->generateUrl('admin_partenaire_edit', array('id' => $id)));

    }

    /**
     * Deletes a Partenaire entity.
     *
     * @Route("/{id}/delete", name="admin_partenaire_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AmlWebBundle:Partenaire')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Partenaire entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_partenaire'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
