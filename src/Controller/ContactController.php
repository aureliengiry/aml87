<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Controller;

use App\Contact\ContactMessage;
use App\Entity\Message;
use App\Form\Type\MessageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Contact Us controller.
 *
 * @Route("/contact-us")
 */
final class ContactController extends AbstractController
{
    private ContactMessage $contactMessage;

    public function __construct(ContactMessage $contactMessage)
    {
        $this->contactMessage = $contactMessage;
    }

    /**
     * Index Action to display contact form.
     *
     * @Route("/", name="aml_contactus_default_index", methods={"GET", "POST"})
     */
    public function index(Request $request): Response
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

        return $this->render('contact/index.html.twig', [
            'entity' => $contactMessage,
            'contact_form' => $form->createView(),
        ]);
    }
}
