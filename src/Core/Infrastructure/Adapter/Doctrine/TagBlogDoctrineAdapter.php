<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Core\Infrastructure\Adapter\Doctrine;

use App\Core\Domain\Model\Tag;
use App\Core\Domain\Tag\ObtainTagsInterface;
use App\Core\Infrastructure\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class TagBlogDoctrineAdapter.
 */
class TagBlogDoctrineAdapter implements ObtainTagsInterface
{
    /** @var EntityManagerInterface */
    private $em;

    /**
     * TagBlogDoctrineAdapter constructor.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getTagsWithNbArticles(): iterable
    {
        return $this->getCategoryRepository()->getTagsWithNbArticles();
    }

    private function getCategoryRepository(): TagRepository
    {
        return $this->em->getRepository(Tag::class);
    }
}
