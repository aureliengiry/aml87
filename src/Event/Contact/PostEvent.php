<?php
namespace App\Event\Contact;

use App\Entity\Message;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class PostEvent
 * @package App\Event\Contact
 */
class PostEvent extends Event
{
    protected $post;

    public function __construct(Message $post)
    {
        $this->post = $post;
    }

    public function getPost()
    {
        return $this->post;
    }
}
