<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\ContactMessage\Domain;

use App\ContactMessage\Domain\Model\Message;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class PostEvent.
 */
class PostEvent extends Event
{
    /** @var Message */
    protected $post;

    /**
     * PostEvent constructor.
     */
    public function __construct(Message $post)
    {
        $this->post = $post;
    }

    public function getPost(): Message
    {
        return $this->post;
    }
}
