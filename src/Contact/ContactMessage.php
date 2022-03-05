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
    private EntityManagerInterface $entityManager;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(
        EntityManagerInterface $entityManager,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Save message and dispatch event.
     */
    public function save(Message $message): void
    {
        $this->entityManager->persist($message);
        $this->entityManager->flush();

        if (false === $message->isSpam()) {
            $this->eventDispatcher->dispatch(new MessageSaved($message));
        }
    }
}
