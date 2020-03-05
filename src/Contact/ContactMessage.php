<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Contact;

use App\Entity\Message;
use App\Event\Contact\PostEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class ContactMessage.
 */
class ContactMessage
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var EventDispatcherInterface */
    private $eventDispatcher;

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
            $this->eventDispatcher->dispatch('aml_contactus.message.post_sent', new PostEvent($message));
        }
    }
}
