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
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class PostListener implements EventSubscriberInterface
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly EntityManagerInterface $entityManager,
        private readonly string $subscribers
    ) {
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

        if ('' !== $this->subscribers) {
            foreach (explode(',', $this->subscribers) as $subscriber) {
                $mail = (new Email())
                    ->subject($formatedMessage['subject'])
                    ->from(new Address($post->getEmail(), $post->getName()))
                    ->to($subscriber)
                    ->text($formatedMessage['body']);

                $this->mailer->send($mail);

                $post->setStatus(Message::MESSAGE_STATUS_SAVE_SEND);
                $this->entityManager->persist($post);
            }

            $this->entityManager->flush();
        }
    }

    /**
     * Function to format email.
     *
     * @return array{subject: string, body: string}
     */
    private function formatMessage(Message $post): array
    {
        return ['subject' => 'AML87 - '.$post->getName().' cherche à vous contacter', 'body' => 'Bonjour,

'
            .$post->getName().'('.$post->getEmail(
            ).") vous ecrit par l'intermediaire du formulaire de contact : \n\n".$post->getBody()];
    }
}
