<?php

namespace Aml\Bundle\ContactUsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


use Aml\Bundle\ContactUsBundle\Entity\Message;
use Aml\Bundle\ContactUsBundle\Form\MessageType;

/**
 * Contact Us controller.
 *
 * @Route("/contact-us")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="contact_us")
     * @Template()
     */
    public function indexAction()
    {
        $entity = new Message();
        $form = $this->createForm(new MessageType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/post", name="contact_us_post")
     * @Method("post")
     * @Template("AmlContactUsBundle:Default:index.html.twig")
     */
    public function postAction()
    {
        $entity = new Message();
        $request = $this->getRequest();
        $form = $this->createForm(new MessageType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity
                ->setAddressIp($request->getClientIp())
                ->setCreated(new \DateTime())
                ->setStatus(1)
            ;

            $em->persist($entity);
            $em->flush();

            $this->get('session')->setFlash('success', 'E-mail envoyé avec succès');
            return $this->redirect($this->generateUrl('aml_contact_us_index'));

        }

        return array(
            'entity' => $entity,
            'form' => $form->createView()
        );

    }


}
