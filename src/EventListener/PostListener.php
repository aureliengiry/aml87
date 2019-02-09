<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\EventListener;

use App\ContactMessage\Domain\Model\Message;
use App\ContactMessage\Domain\PostEvent;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class PostListener.
 */
class PostListener
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var string
     */
    private $subscribers;

    /**
     * PostListener constructor.
     */
    public function __construct(\Swift_Mailer $mailer, ObjectManager $entityManager, string $subscribers = null)
    {
        $this->mailer = $mailer;
        $this->em = $entityManager;
        $this->subscribers = $subscribers;
    }

    public function onPostEvent(PostEvent $event): void
    {
        $post = $event->getPost();

        $formatedMessage = $this->formatMessage($post);

        if (!empty($this->subscribers)) {
            foreach (\explode(',', $this->subscribers) as $subscriber) {
                $mail = (new \Swift_Message($formatedMessage['subject']))
                    ->setFrom($post->getEmail(), $post->getName())
                    ->setTo($subscriber)
                    ->setBody($formatedMessage['body']);

                $this->mailer->send($mail);

                $post->setStatus(Message::MESSAGE_STATUS_SAVE_SEND);
                $this->em->persist($post);
            }

            $this->em->flush();
        }
    }

    /**
     * Function to format email.
     */
    private function formatMessage(Message $post): array
    {
        $message = [];

        $message['subject'] = 'AML87 - '.$post->getName().' cherche à vous contacter';
        $message['body'] = 'Bonjour,'."\n\n"
            .$post->getName().'('.$post->getEmail(
            ).') vous ecrit par l\'intermediaire du formulaire de contact : '."\n\n"
            .$post->getBody();

        return $message;
    }
}
