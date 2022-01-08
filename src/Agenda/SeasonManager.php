<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Agenda;

use App\Entity\Season;
use App\Repository\SeasonRepository;
use Doctrine\Common\Collections\Collection;

class SeasonManager
{
    private SeasonRepository $seasonRepository;

    public function __construct(SeasonRepository $seasonRepository)
    {
        $this->seasonRepository = $seasonRepository;
    }

    /**
     * @return Season[]
     */
    public function getAllSeasons(): Collection
    {
        return $this->seasonRepository->findAll();
    }

    public function getCurrentSeason(): ?Season
    {
        return $this->seasonRepository->getSeasonByDateStart(new \DateTime());
    }

    public function getNextSeasonByDate(\DateTime $dateTime): void
    {
    }

    public function getPastSeasons(): iterable
    {
        return $this->seasonRepository->getPastSeasons();
    }
}
