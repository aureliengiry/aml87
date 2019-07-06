<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Post\Domain\Services;

use App\Post\Domain\Exception\PostNotFoundException;
use App\Post\Domain\Model\Post;
use App\Post\Domain\PostsInterface;

/**
 * Class PostManager.
 */
class PostManager
{ 
    /** @var PostsInterface */
    private $postRepository;

    /**
     * PostDoctrineAdapter constructor.
     */
    public function __construct(
        PostsInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getPublicPostsWithPagination(int $page, array $filter): iterable
    {
        return $this->getPostRepository()->getPublicArticles($page, $filter);
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \App\Post\Domain\Exception\PostNotFoundException
     */
    public function getPostBySlug(string $slug): Post
    {
        if (\is_numeric($slug)) {
            $post = $this->getPostRepository()->find($slug);
        } else {
            $post = $this->getPostRepository()->getArticleByUrlKey($slug);
        }

        if (null === $post) {
            throw new PostNotFoundException(\sprintf('Post with slug "%s" not found', $slug));
        }

        return $post;
    }

    private function getPostRepository(): PostsInterface
    {
        return $this->postRepository;
    }

    public function getLastPublicPost() : ?Post
    {       
        return $this->getPostRepository()->findLastPublicPost();
    }
}
