<?php
/**
 * Created by PhpStorm.
 * User: Aurélien
 * Date: 21/04/14
 * Time: 19:39
 */
namespace Aml\Bundle\ContactUsBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class PostEvent
 * @package Aml\Bundle\ContactUsBundle\Event
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
