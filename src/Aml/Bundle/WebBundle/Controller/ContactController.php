<?php

namespace Aml\Bundle\WebBundle\Controller;

use Aml\Bundle\WebBundle\Contact\ContactMessage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Aml\Bundle\WebBundle\Entity\Message;
use Aml\Bundle\WebBundle\Form\Type\MessageType;

/**
 * Contact Us controller.
 *
 * @Route("/contact-us")
 */
class ContactController extends Controller
{
    /**
     * Index Action to display contact form
     *
     * @Route("/", name="aml_contactus_default_index")
     * @Template("contact/index.html.twig")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $contactMessage = new Message();
        $form = $this->createForm(MessageType::class, $contactMessage)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contactMessage
                ->setAddressIp($request->getClientIp())
                ->setStatus(Message::MESSAGE_STATUS_SAVE);

            $this->get(ContactMessage::class)->save($contactMessage);

            $this->addFlash('success', 'E-mail envoyé avec succès');

            return $this->redirectToRoute('aml_contactus_default_index');
        }

        return [
            'entity'       => $contactMessage,
            'contact_form' => $form->createView(),
        ];
    }
}
