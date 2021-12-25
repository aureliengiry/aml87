<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Article;

use App\Entity\Article;
use App\Entity\Tags;
use Doctrine\ORM\EntityManagerInterface;

class ArticleManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getPublicArticlesWithPagination(int $page, array $filter)
    {
        return $this->getArticleRepository()->getPublicArticles($page, $filter);
    }

    public function getArticleByIdOrUrl($urlKey)
    {
        if (\is_int($urlKey)) {
            return $this->getArticleRepository()->find($urlKey);
        }

        return $this->getArticleRepository()->getArticleByUrlKey($urlKey);
    }

    private function getArticleRepository()
    {
        return $this->entityManager->getRepository(Article::class);
    }

    private function getTagsRepository()
    {
        return $this->entityManager->getRepository(Tags::class);
    }

    public function getTagsWithNbArticles()
    {
        return $this->getTagsRepository()->getTagsWithNbArticles();
    }
}
