<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Post\Domain;

use App\Post\Domain\Exception\PostNotFoundException;
use App\Post\Domain\Model\Post;
use App\Post\Domain\PostsInterface;
use App\Post\Infrastructure\Doctrine\PostDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class PostManager.
 */
class PostManager implements PostsInterface
{
    /** @var EntityManagerInterface */
    private $em;

    /**
     * PostDoctrineAdapter constructor.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
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

    private function getPostRepository(): PostDoctrineRepository
    {
        return $this->em->getRepository(Post::class);
    }
}
