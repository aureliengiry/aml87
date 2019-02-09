<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Post\Domain\Model;

use App\Post\Domain\ValueObject\PostContent;
use App\Post\Domain\ValueObject\PostSlug;
use App\Post\Domain\ValueObject\PostUuid;

/**
 * Class Post.
 */
final class Post
{
    const ARTICLE_IS_PUBLIC = 1;
    const ARTICLE_IS_PRIVATE = 0;

    private $id;
    private $uuid;

    private $content;

    private $createdAt;
    private $category;

    private $tags;
    private $slug;

    public function __construct(
        PostUuid $uuid,
        PostContent $content,
        Category $category = null,
        TagCollection $tags = null)
    {
        $this->uuid = $uuid;

        $this->createdAt = new \DateTimeImmutable();

        $this->content = $content;

        $this->category = $category;
        $this->tags = $tags;

        $articleSlug = new PostSlug($content);
        $this->slug = $articleSlug->getValue();
    }

    public function getUuid(): PostUuid
    {
        return $this->uuid;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getContent(): PostContent
    {
        return $this->content;
    }
}
