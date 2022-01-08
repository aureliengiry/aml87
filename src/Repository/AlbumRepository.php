<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Repository;

use App\Entity\Album;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Album|null find($id, $lockMode = null, $lockVersion = null)
 * @method Album|null findOneBy(array $criteria, array $orderBy = null)
 * @method Album[]    findAll()
 * @method Album[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlbumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Album::class);
    }

    public function getAlbumByUrlKey($urlKey)
    {
        $q = $this->getEntityManager()->createQueryBuilder();
        $q
            ->select('e')
            ->from(Album::class, 'e')
            ->join('e.url', 'u')
            ->where('u.urlKey = :url_key')
            ->setMaxResults(1);

        $params = ['url_key' => $urlKey];

        $q->setParameters($params);

        return $q->getQuery()->getOneOrNullResult();
    }
}
