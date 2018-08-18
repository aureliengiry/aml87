<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Repository;

use App\Entity\Page;
use App\Entity\UrlPage;
use Doctrine\ORM\EntityRepository;

/**
 * PageRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PageRepository extends EntityRepository
{
    public function getPublicPageByUrlKey($urlKey)
    {
        $q = $this->getEntityManager()->createQueryBuilder();
        $q
            ->select('p')
            ->from(Page::class, 'p')
            ->innerJoin(UrlPage::class, 'up', 'WITH', 'p.url=up.id')
            ->where('up.urlKey = :url_key')
            ->andWhere('p.public = :public')
            ->setMaxResults(1);

        $q->setParameters([
            'url_key' => $urlKey,
            'public' => Page::PAGE_IS_PUBLIC,
        ]);

        return $q->getQuery()->getOneOrNullResult();
    }
}
