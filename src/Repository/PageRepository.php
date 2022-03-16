<?php

declare(strict_types=1);

/**
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>.
 */

namespace App\Repository;

use App\Entity\Page;
use App\Entity\UrlPage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Page>
 *
 * @method Page|null find($id, $lockMode = null, $lockVersion = null)
 * @method Page|null findOneBy(array $criteria, array $orderBy = null)
 * @method Page[]    findAll()
 * @method Page[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Page::class);
    }

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
