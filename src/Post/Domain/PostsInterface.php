<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Post\Domain;

interface PostsInterface
{
    public function getPublicArticles(int $page, array $filters, int $limit);

    public function getArticleByUrlKey($urlKey);

    public function findLastPublicPost();
}
