<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Agenda;

use App\Entity\Evenement;
use App\Entity\Season;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class Agenda.
 */
class Agenda
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getCurrentSeason(): void
    {
    }

    public function getPublicEventsBySeason()
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
        return $this->entityManager->getRepository(Evenement::class);
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
