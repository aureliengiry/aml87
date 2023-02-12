<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Article;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\TagsRepository;

class ArticleManager
{
    public function __construct(private readonly ArticleRepository $articleRepository, private readonly TagsRepository $tagsRepository)
    {
    }

    public function getPublicArticlesWithPagination(int $page, array $filter): \Doctrine\ORM\Tools\Pagination\Paginator
    {
        return $this->articleRepository->getPublicArticles($page, $filter);
    }

    public function getArticleByIdOrUrl($urlKey): ?Article
    {
        if (\is_int($urlKey)) {
            return $this->articleRepository->find($urlKey);
        }

        return $this->articleRepository->getArticleByUrlKey($urlKey);
    }

    public function getTagsWithNbArticles(): iterable
    {
        return $this->tagsRepository->getTagsWithNbArticles();
    }
}
