<?php
namespace App\Event\Contact;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class PostEvent
 * @package App\Event\Contact
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
