<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Agenda;

use App\Entity\Evenement;
use App\Entity\Season;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class Agenda.
 */
class Agenda
{
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ObjectManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getCurrentSeason()
    {
    }

    public function getPublicEventsBySeason(Season $season)
    {
        return $this->getEventRepository()->getNextEvenements([
            'public' => 1,
            'archive' => 0,
            'type' => Evenement::EVENEMENT_TYPE_CONCERT,
        ]);
    }

    public function getAllEventsBySeason(Season $season)
    {
        return $this->getEventRepository()->findBySeason($season);
    }

    public function getEventByIdOrUrl(string $urlKey)
    {
        if (\is_int($urlKey)) {
            return $this->getEventRepository()->find($urlKey);
        }

        return $this->getEventRepository()->getEventByUrlKey($urlKey);
    }

    private function getEventRepository()
    {
        return $this->em->getRepository(Evenement::class);
    }

    public function getNextConcert()
    {
        return $this->getEventRepository()->findNextConcert();
    }

    public function getArchivedConcertBySeason(Season $season)
    {
        return $this->getEventRepository()->findArchivedConcertBySeason($season);
    }
}
