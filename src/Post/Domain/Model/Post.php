<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Post\Domain\Model;

use App\Core\DDD\Model\AggregateRoot;
use App\Post\Domain\ValueObject\PostContent;
use App\Post\Domain\ValueObject\PostSlug;
use App\Post\Domain\ValueObject\PostUuid;
use App\Core\Domain\Model\Category;

/**
 * Class Post.
 */
final class Post implements AggregateRoot
{
    const ARTICLE_IS_PUBLIC = 1;
    const ARTICLE_IS_PRIVATE = 0;

    private $id;
    private $uuid;

    /** @var PostContent */
    private $content;

    private $createdAt;
    private $public = false;
    private $category;

    private $tags = [];
    private $slug;

    public function __construct(
        PostUuid $uuid,
        PostContent $content,
        Category $category = null,
        iterable $tags = null,
        bool $public = null)
    {
        $this->uuid = $uuid;

        $this->createdAt = new \DateTimeImmutable();

        $this->content = $content;

        $this->category = $category;
        $this->tags = $tags;

        $articleSlug = new PostSlug($content);
        $this->slug = $articleSlug->getValue();

        if(null !== $public){
            $this->public = $public;
        }
    }

    /**
     * @return mixed
     */
    public function getId() : ?int
    {
        return $this->id;
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

    public function getContentTitle() : ?string
    {
        return $this->getContent()->getTitle();
    }

    public function getContentBody() : ?string
    {
        return $this->getContent()->getBody();
    }

    public function getSlug() : string
    {
        return $this->slug;
    }

    public function getCategory() : ?Category
    {
        return $this->category;
    }

    public function getVideo()
    {
        return null;
    }

    public function getLogo()
    {
        return null;
    }

    public function getTags() : iterable
    {
        return $this->tags;
    }

    public function isPublic(): bool
    {
        return $this->public;
    }

    /**
     * Set public.
     */
    public function setPublic(bool $public): void
    {
        $this->public = $public;
    }
}
