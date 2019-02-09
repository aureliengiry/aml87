<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Core\Infrastructure\Adapter\Doctrine;

use App\Core\Domain\Category\ObtainCategoriesInterface;
use App\Core\Domain\Model\Category;
use App\Core\Infrastructure\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CategoryBlogDoctrineAdapter.
 */
class CategoryBlogDoctrineAdapter implements ObtainCategoriesInterface
{
    /** @var EntityManagerInterface */
    private $em;

    /**
     * CategoryBlogDoctrineAdapter constructor.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getCategoriesWithNbArticles(): iterable
    {
        return $this->getCategoryRepository()->getCategoriesWithNbArticles();
    }

    private function getCategoryRepository(): CategoryRepository
    {
        return $this->em->getRepository(Category::class);
    }
}
