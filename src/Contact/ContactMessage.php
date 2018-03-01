<?php

namespace App\Contact;

use App\Message;
use App\Event\Contact\PostEvent;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class ContactMessage
 * @package App\Contact
 */
class ContactMessage
{
    /** @var EntityManager  */
    private $em;
    private $mailer;
    private $eventDispatcher;

    public function __construct(
        EntityManager $entityManager,
        \Swift_Mailer $mailer,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->em = $entityManager;
        $this->mailer = $mailer;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Save message and dispatch event
     *
     * @param Message $message
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
