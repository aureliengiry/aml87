<?php

namespace Aml\Bundle\EvenementsBundle\Repository;

use Aml\Bundle\EvenementsBundle\Entity\Evenement;
use Aml\Bundle\EvenementsBundle\Entity\Season;
use Doctrine\ORM\EntityRepository;

/**
 * Evenement
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EvenementRepository extends EntityRepository
{
    /**
     * Get events filter by date start and date end
     *
     * @param $dateStart
     * @param $dateEnd
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
                    //'date_end' => $dateTimeEnd,
                ]
            );

        return $q->getQuery()->getResult();
    }

    /**
     * Function to build request in order to filter blog articles
     *
     * @param $query
     * @param array $params
     * @param array $filters
     * @return mixed
     */
    private function buildRequestByFilters($query, $params = [], $filters = [])
    {
        if (isset($filters['archive'])) {
            $query
                ->andWhere("e.archive = :archive");
            $params['archive'] = $filters['archive'];
        }

        if (isset($filters['public'])) {
            $query
                ->andWhere("e.public = :public");
            $params['public'] = $filters['public'];
        }
        if (isset($filters['type']) && !empty($filters['type'])) {
            $query
                ->andWhere("e.type = :type");
            $params['type'] = $filters['type'];
        }

        $query->setParameters($params);

        return $query;
    }

    /**
     * Get events not archived
     *
     * @param array $filters
     * @return mixed
     */
    public function getNextEvenements($filters = [])
    {
        $dateTimeStart = new \DateTime();
        $dateTimeStart->setTime(0, 0);

        $q = $this->getEntityManager()->createQueryBuilder();
        $q
            ->select('e')
            ->from(Evenement::class, 'e')
            ->orderBy('e.dateStart', 'ASC');

        $q = $this->buildRequestByFilters($q, $params = [], $filters);

        $query = $q->getQuery();

        return $query->getResult();
    }

    /**
     * Retrieve archived concerts filter by season
     *
     * @param Season $season
     *
     * @return mixed
     */
    public function findArchivedConcertBySeason(Season $season)
    {
        $dateTimeStart = new \DateTime();
        $dateTimeStart->setTime(0, 0);

        $q = $this->getEntityManager()->createQueryBuilder();
        $q
            ->select('e')
            ->from(Evenement::class, 'e')
            ->where("e.archive = :archive")
            ->andWhere("e.public = :public")
            ->andWhere("e.season = :season")
            ->andWhere("e.type = :type")
            ->orderBy('e.dateStart', 'ASC');

        $params = [
            'archive' => 1,
            'public'  => 1,
            'season'  => $season,
            'type'    => Evenement::EVENEMENT_TYPE_CONCERT,

        ];

        $q->setParameters($params);

        $query = $q->getQuery();

        return $query->getResult();
    }

    /**
     * Function to load next concert
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
            'type'    => Evenement::EVENEMENT_TYPE_CONCERT,
            'archive' => 0,
            'public'  => 1,
        ];

        $q = $this->buildRequestByFilters($q, $params, $filters);

        $query = $q->getQuery();

        try {
            return $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
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

        $query = $q->getQuery();

        try {
            return $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}
