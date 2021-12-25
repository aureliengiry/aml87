<?php

declare(strict_types=1);

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
use Twig\Environment;

/**
 * @Route("/contact-us")
 */
final class ContactUsController extends AbstractController
{
    /**
     * Index Action to display contact form.
     *
     * @Route("/", name="aml_contactus_default_index", methods={"GET", "POST"})
     */
    public function index(
        Request $request,
        ContactMessage $contactMessageService,
        Environment $twig
    ): Response {
        $contactMessage = new Message();
        $form = $this->createForm(MessageType::class, $contactMessage)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactMessage
                ->setAddressIp($request->getClientIp())
                ->setStatus(Message::MESSAGE_STATUS_SAVE);

            $contactMessageService->save($contactMessage);

            $this->addFlash('success', 'E-mail envoyé avec succès');

            return $this->redirectToRoute('aml_contactus_default_index');
        }

        return new Response($twig->render('contact/index.html.twig', [
            'entity' => $contactMessage,
            'contact_form' => $form->createView(),
        ]));
    }
}
