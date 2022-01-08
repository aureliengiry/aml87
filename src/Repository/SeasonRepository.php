<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Repository;

use App\Entity\Season;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Season|null find($id, $lockMode = null, $lockVersion = null)
 * @method Season|null findOneBy(array $criteria, array $orderBy = null)
 * @method Season[]    findAll()
 * @method Season[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeasonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Season::class);
    }

    /**
     * Laod seasons by date start.
     *
     * @return mixed|null
     */
    public function getSeasonByDateStart(\DateTime $eventDateStart): ?Season
    {
        $q = $this->getEntityManager()->createQueryBuilder();
        $q
            ->select('s')
            ->from(Season::class, 's')
            ->where('s.dateStart <= :eventDateStart')
            ->andWhere('s.dateEnd >= :eventDateStart')
            ->orderBy('s.dateStart', 'ASC')
            ->setMaxResults(1);

        $params = [
            'eventDateStart' => $eventDateStart,
        ];

        $q->setParameters($params);

        return $q->getQuery()->getOneOrNullResult();
    }

    /**
     * Retrieve last past season.
     *
     * @return mixed|null
     */
    public function getLastSeason(): ?Season
    {
        $q = $this->getEntityManager()->createQueryBuilder();
        $q
            ->select('s')
            ->from(Season::class, 's')
            ->where('s.dateEnd < CURRENT_DATE()')
            ->orderBy('s.dateStart', 'DESC')
            ->setMaxResults(1);

        return $q->getQuery()->getOneOrNullResult();
    }

    /**
     * Load past seasons.
     *
     * @return array|null
     */
    public function getPastSeasons()
    {
        $q = $this->getEntityManager()->createQueryBuilder();
        $q
            ->select('s.id', 's.name', 'COUNT(e.id) as nb_events')
            ->from(Season::class, 's')
            ->where('s.dateEnd < CURRENT_DATE()')
            ->leftJoin('s.evenements', 'e', 'WITH', 'e.archive=:archive AND e.public=:public')
            ->groupBy('s.id')
            ->orderBy('s.dateStart', 'DESC');

        $params = [
            'archive' => 1,
            'public' => 1,
        ];

        $q->setParameters($params);

        return $q->getQuery()->getResult();
    }
}
