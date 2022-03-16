<?php

declare(strict_types=1);

/**
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>.
 */

namespace App\Event\Contact;

use App\Entity\Message;
use Symfony\Contracts\EventDispatcher\Event;

class MessageSaved extends Event
{
    public function __construct(private readonly Message $message)
    {
    }

    public function getMessage(): Message
    {
        return $this->message;
    }
}
