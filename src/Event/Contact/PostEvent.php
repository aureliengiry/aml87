<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Event\Contact;

use App\Entity\Message;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class PostEvent.
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
