<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Post\Domain\ValueObject;

use App\Core\Domain\Utils\Slugger;
use App\Post\Domain\Exception\PostContentEmptyException;

/**
 * Class PostSlug.
 */
class PostSlug
{
    /** @var string */
    private $value;

    public function __construct(PostContent $postContent)
    {
        if (!$postContent || empty($postContent->getTitle())) {
            throw new PostContentEmptyException();
        }

        $slugger = new Slugger();

        $this->value = $slugger->slugify($postContent->getTitle());
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
