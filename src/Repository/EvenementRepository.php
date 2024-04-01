<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Repository;

use App\Entity\Evenement;
use App\Entity\Season;
use App\Entity\UrlEvenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Evenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evenement[]    findAll()
 * @method Evenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evenement::class);
    }

    /**
     * Get events filter by date start and date end.
     *
     * @return array
     */
    public function getEvenementsCalendar($dateStart, $dateEnd)
    {
        $dateTimeStart = new \DateTime();
        $dateTimeStart->setTimestamp($dateStart);

        $dateTimeEnd = new \DateTime();
        $dateTimeEnd->setTimestamp($dateEnd);

        $q = $this->getEntityManager()->createQueryBuilder();
        $q
            ->select('e')
            ->from(Evenement::class, 'e')
            ->where('e.dateStart > :dateStart')
            // ->andWhere('e.date_start < :date_end')
            ->orderBy('e.dateStart', 'ASC')
            ->setParameters(
                [
                    'dateStart' => $dateTimeStart,
                    // 'date_end' => $dateTimeEnd,
                ]
            );

        return $q->getQuery()->getResult();
    }

    /**
     * Function to build request in order to filter blog articles.
     */
    private function buildRequestByFilters(\Doctrine\ORM\QueryBuilder $query, array $params = [], array $filters = []): \Doctrine\ORM\QueryBuilder
    {
        if (isset($filters['archive'])) {
            $query
                ->andWhere('e.archive = :archive');
            $params['archive'] = $filters['archive'];
        }

        if (isset($filters['public'])) {
            $query
                ->andWhere('e.public = :public');
            $params['public'] = $filters['public'];
        }

        if (isset($filters['type']) && ! empty($filters['type'])) {
            $query
                ->andWhere('e.type = :type');
            $params['type'] = $filters['type'];
        }

        $query->setParameters($params);

        return $query;
    }

    /**
     * Get events not archived.
     *
     * @param array $filters
     */
    public function getNextEvenements($filters = [])
    {
        $dateTimeStart = new \DateTime();
        $dateTimeStart->setTime(0, 0);

        $q = $this->getEntityManager()->createQueryBuilder();
        $q
            ->select('e.title', 'e.dateStart')
            ->addSelect('eurl.urlKey as slug')
            ->from(Evenement::class, 'e')
            ->leftJoin(UrlEvenement::class, 'eurl', 'WITH', 'eurl.id=e.url')
            ->orderBy('e.dateStart', 'ASC');

        $q = $this->buildRequestByFilters($q, $params = [], $filters);

        return $q->getQuery()->execute();
    }

    /**
     * Retrieve archived concerts filter by season.
     */
    public function findArchivedConcertBySeason(Season $season)
    {
        $dateTimeStart = new \DateTime();
        $dateTimeStart->setTime(0, 0);

        $q = $this->getEntityManager()->createQueryBuilder();
        $q
            ->select('e.title', 'e.dateStart')
            ->addSelect('eurl.urlKey as slug')
            ->from(Evenement::class, 'e')
            ->leftJoin(UrlEvenement::class, 'eurl', 'WITH', 'eurl.id=e.url')
            ->where('e.archive = :archive')
            ->andWhere('e.public = :public')
            ->andWhere('e.season = :season')
            ->andWhere('e.type = :type')
            ->orderBy('e.dateStart', 'ASC');

        $params = [
            'archive' => 1,
            'public' => 1,
            'season' => $season,
            'type' => Evenement::EVENEMENT_TYPE_CONCERT,
        ];

        $q->setParameters($params);

        $query = $q->getQuery();

        return $query->getResult();
    }

    /**
     * Function to load next concert.
     *
     * @return Evenement|null
     */
    public function findNextConcert()
    {
        $currentDate = new \DateTime();
        $currentDate->setTime(0, 0);

        $q = $this->getEntityManager()->createQueryBuilder();
        $q
            ->select('e')
            ->from(Evenement::class, 'e')
            ->where('e.dateStart >= :currentDate')
            ->orderBy('e.dateStart', 'ASC')
            ->setMaxResults(1);

        $params = [
            'currentDate' => $currentDate,
        ];

        $filters = [
            'type' => Evenement::EVENEMENT_TYPE_CONCERT,
            'archive' => 0,
            'public' => 1,
        ];

        $q = $this->buildRequestByFilters($q, $params, $filters);

        $query = $q->getQuery();

        try {
            return $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException) {
            return null;
        }
    }

    public function getEventByUrlKey($urlKey)
    {
        $q = $this->getEntityManager()->createQueryBuilder();
        $q
            ->select('e')
            ->from(Evenement::class, 'e')
            ->join('e.url', 'u')
            ->where('u.urlKey = :url_key')
            ->setMaxResults(1);

        $params = [
            'url_key' => $urlKey,
        ];

        $q->setParameters($params);

        return $q->getQuery()->getOneOrNullResult();
    }
}
