<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Core\Infrastructure\Adapter\Doctrine;

use App\Page\Domain\Exception\PageNotFoundException;
use App\Page\Domain\Model\Page;
use App\Page\Domain\ObtainPageInterface;
use App\Page\Infrastructure\Doctrine\PageDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class PageDoctrineAdapter.
 */
class PageDoctrineAdapter implements ObtainPageInterface
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getPublicPageBySlug(string $slug): Page
    {
        if (\is_numeric($slug)) {
            $page = $this->getPageRepository()->find($slug);
        } else {
            $page = $this->getPageRepository()->getPublicPageByUrlKey($slug);
        }

        if (null === $page) {
            throw new PageNotFoundException(\sprintf('Page with slug "%s" not found', $slug));
        }

        return $page;
    }

    private function getPageRepository(): PageDoctrineRepository
    {
        return $this->em->getRepository(Page::class);
    }
}
