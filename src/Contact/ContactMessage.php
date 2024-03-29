<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Contact;

use App\Entity\Message;
use App\Event\Contact\MessageSaved;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class ContactMessage.
 */
class ContactMessage
{
    public function __construct(private readonly EntityManagerInterface $entityManager, private readonly EventDispatcherInterface $eventDispatcher)
    {
    }

    /**
     * Save message and dispatch event.
     */
    public function save(Message $message): void
    {
        $this->entityManager->persist($message);
        $this->entityManager->flush();

        if ( ! $message->isSpam()) {
            $this->eventDispatcher->dispatch(new MessageSaved($message));
        }
    }
}
