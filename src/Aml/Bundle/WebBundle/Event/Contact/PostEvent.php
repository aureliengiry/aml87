<?php
namespace Aml\Bundle\WebBundle\Event\Contact;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class PostEvent
 * @package Aml\Bundle\WebBundle\Event\Contact
 */
class PostEvent extends Event
{
    protected $post;

    public function __construct($post)
    {
        $this->post = $post;
    }

    public function getPost()
    {
        return $this->post;
    }
}
