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
    private ArticleRepository $articleRepository;
    private TagsRepository $tagsRepository;

    public function __construct(
        ArticleRepository $articleRepository,
        TagsRepository $tagsRepository
    ) {
        $this->articleRepository = $articleRepository;
        $this->tagsRepository = $tagsRepository;
    }

    public function getPublicArticlesWithPagination(int $page, array $filter)
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
