<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Post\Domain\ValueObject;

use App\Post\Domain\Exception\PostContentEmptyException;

/**
 * Class PostContent.
 */
class PostContent
{
    private $title;
    private $body;

    public function __construct(string $title, string $body)
    {
        if (empty($title) or empty($body)) {
            throw new PostContentEmptyException();
        }

        $this->title = $title;
        $this->body = $body;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }
}
