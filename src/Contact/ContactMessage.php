<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Contact;

use App\Entity\Message;
use App\Event\Contact\PostEvent;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class ContactMessage.
 */
class ContactMessage
{
    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(
        ObjectManager $entityManager,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->em = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Save message and dispatch event.
     */
    public function save(Message $message)
    {
        $this->em->persist($message);
        $this->em->flush();

        if (false === $message->isSpam()) {
            $this->eventDispatcher->dispatch('aml_contactus.message.post_sent', new PostEvent($message));
        }
    }
}
