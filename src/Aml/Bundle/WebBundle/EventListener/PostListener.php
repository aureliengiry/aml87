<?php

namespace Aml\Bundle\WebBundle\EventListener;

use Aml\Bundle\WebBundle\Event\Contact\PostEvent;
use Doctrine\ORM\EntityManager;
use Aml\Bundle\WebBundle\Entity\Message;

/**
 * Class PostListener
 * @package Aml\Bundle\WebBundle\EventListener
 */
class PostListener
{
    private $mailer;
    private $em;
    private $subscribers;

    /**
     * PostListener constructor.
     *
     * @param \Swift_Mailer $mailer
     * @param EntityManager $entityManager
     * @param string $subscribers
     */
    public function __construct(\Swift_Mailer $mailer, EntityManager $entityManager, string $subscribers = null)
    {
        $this->mailer = $mailer;
        $this->em = $entityManager;
        $this->subscribers = $subscribers;
    }

    /**
     * @param PostEvent $event
     */
    public function onPostEvent(PostEvent $event)
    {
        $post = $event->getPost();

        $formatedMessage = $this->formatMessage($post);

        if (!empty($this->subscribers)) {

            foreach (explode(',', $this->subscribers) as $subscriber) {
                $mail = \Swift_Message::newInstance()
                    ->setSubject($formatedMessage['subject'])
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
     * Function to format email
     *
     * @param Message $post
     */
    private function formatMessage(Message $post): array
    {
        $message = array();

        $message['subject'] = 'AML87 - '.$post->getName().' cherche à vous contacter';
        $message['body'] = 'Bonjour,'."\n\n"
            .$post->getName().'('.$post->getEmail(
            ).') vous ecrit par l\'intermediaire du formulaire de contact : '."\n\n"
            .$post->getBody();

        return $message;
    }
}
