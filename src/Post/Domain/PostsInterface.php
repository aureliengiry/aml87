<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Post\Domain;

use App\Post\Domain\Model\Post;

interface PostsInterface
{
    public function getPublicPostsWithPagination(int $page, array $filter): iterable;

    /**
     * @throws \App\Post\Domain\PostNotFoundException
     */
    public function getPostBySlug(string $slug): Post;
}
