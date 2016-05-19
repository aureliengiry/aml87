<?php

namespace Aml\Bundle\ContactUsBundle\EventListener;

use Aml\Bundle\ContactUsBundle\Event\PostEvent;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Aml\Bundle\ContactUsBundle\Entity\Message;

/**
 * Class PostListener
 * @package Aml\Bundle\ContactUsBundle\EventListener
 */
class PostListener
{
    protected $mailer;
    private $container;

    /**
     * @param \Swift_Mailer $mailer
     * @param Container $container
     */
    public function __construct(\Swift_Mailer $mailer, Container $container)
    {
        $this->mailer = $mailer;
        $this->container = $container;
    }

    /**
     * @param PostEvent $event
     */
    public function onPostEvent(PostEvent $event)
    {
        $post = $event->getPost();

        $formatedMessage = $this->formatMessage($post);

        if ($this->container->hasParameter('aml_contact_us.subriber')) {
            $getSubscribers = $this->container->getParameter('aml_contact_us.subriber');

            foreach (explode(',', $getSubscribers) as $subscriber) {
                $message = \Swift_Message::newInstance()
                    ->setSubject($formatedMessage['subject'])
                    ->setFrom($post->getEmail())
                    ->setTo($subscriber)
                    ->setBody($formatedMessage['body']);
                $this->mailer->send($message);

                $post->setStatus(Message::MESSAGE_STATUS_SAVE_SEND);
                $em = $this->container->get('doctrine')->getManager('default');
                $em->persist($post);
            }

            $em->flush();
        }
    }

    /**
     * Fonction to format email
     *
     * @param $post
     * @return array
     */
    private function formatMessage(Message $post)
    {
        $message = array();

        $message['subject'] = 'AML87 - ' . $post->getName() . ' cherche à vous contacter';
        $message['body'] = 'Bonjour,' . "\n\n"
            . $post->getName() . '(' . $post->getEmail() . ') vous ecrit par l\'intermediaire du formulaire de contact : ' . "\n\n"
            . $post->getBody();

        return $message;
    }
}
