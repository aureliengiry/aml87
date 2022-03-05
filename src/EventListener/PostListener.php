<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\EventListener;

use App\Entity\Message;
use App\Event\Contact\MessageSaved;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PostListener implements EventSubscriberInterface
{
    private \Swift_Mailer $mailer;

    private EntityManagerInterface $entityManager;

    private string $subscribers;

    public function __construct(
        \Swift_Mailer $mailer,
        EntityManagerInterface $entityManager,
        string $subscribers = null
    ) {
        $this->mailer = $mailer;
        $this->entityManager = $entityManager;
        $this->subscribers = $subscribers;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            MessageSaved::class => 'onPostEvent',
        ];
    }

    public function onPostEvent(MessageSaved $event): void
    {
        $post = $event->getMessage();

        $formatedMessage = $this->formatMessage($post);

        if ( ! empty($this->subscribers)) {
            foreach (explode(',', $this->subscribers) as $subscriber) {
                $mail = (new \Swift_Message($formatedMessage['subject']))
                    ->setFrom($post->getEmail(), $post->getName())
                    ->setTo($subscriber)
                    ->setBody($formatedMessage['body']);

                $this->mailer->send($mail);

                $post->setStatus(Message::MESSAGE_STATUS_SAVE_SEND);
                $this->entityManager->persist($post);
            }

            $this->entityManager->flush();
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
