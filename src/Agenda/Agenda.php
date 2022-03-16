<?php

declare(strict_types=1);

/**
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>.
 */

namespace App\Agenda;

use App\Entity\Evenement;
use App\Entity\Season;
use App\Repository\EvenementRepository;

class Agenda
{
    public function __construct(private readonly EvenementRepository $evenementRepository)
    {
    }

    public function getCurrentSeason(): void
    {
    }

    public function getPublicEventsBySeason(): iterable
    {
        return $this->evenementRepository->getNextEvenements([
            'public' => true,
            'archive' => false,
            'type' => Evenement::EVENEMENT_TYPE_CONCERT,
        ]);
    }

    public function getAllEventsBySeason(Season $season): iterable
    {
        return $this->evenementRepository->findBySeason($season);
    }

    public function getEventByIdOrUrl(string $urlKey): ?Evenement
    {
        if (is_numeric($urlKey)) {
            return $this->evenementRepository->find($urlKey);
        }

        return $this->evenementRepository->getEventByUrlKey($urlKey);
    }

    public function getNextConcert(): ?Evenement
    {
        return $this->evenementRepository->findNextConcert();
    }

    public function getArchivedConcertBySeason(Season $season): iterable
    {
        return $this->evenementRepository->findArchivedConcertBySeason($season);
    }
}
