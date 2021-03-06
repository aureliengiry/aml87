<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Controller;

use App\Contact\ContactMessage;
use App\Entity\Message;
use App\Form\Type\MessageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Contact Us controller.
 *
 * @Route("/contact-us")
 */
class ContactController extends AbstractController
{
    /** @var ContactMessage */
    private $contactMessage;

    public function __construct(ContactMessage $contactMessage)
    {
        $this->contactMessage = $contactMessage;
    }

    /**
     * Index Action to display contact form.
     *
     * @Route("/", name="aml_contactus_default_index", methods={"GET", "POST"})
     * @Template("contact/index.html.twig")
     */
    public function index(Request $request)
    {
        $contactMessage = new Message();
        $form = $this->createForm(MessageType::class, $contactMessage)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactMessage
                ->setAddressIp($request->getClientIp())
                ->setStatus(Message::MESSAGE_STATUS_SAVE);

            $this->contactMessage->save($contactMessage);

            $this->addFlash('success', 'E-mail envoyé avec succès');

            return $this->redirectToRoute('aml_contactus_default_index');
        }

        return [
            'entity' => $contactMessage,
            'contact_form' => $form->createView(),
        ];
    }
}
