<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Agenda;

use App\Entity\Season;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class SeasonManager.
 */
class SeasonManager
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    private function getSeasonRepository()
    {
        return $this->entityManager->getRepository(Season::class);
    }

    public function getAllSeasons(): Collection
    {
        return $this->getSeasonRepository()->findAll();
    }

    public function getCurrentSeason(): ?Season
    {
        return $this->getSeasonRepository()->getSeasonByDateStart(new \DateTime());
    }

    public function getNextSeasonByDate(\DateTime $dateTime)
    {
    }

    public function getPastSeasons()
    {
        return $this->getSeasonRepository()->getPastSeasons();
    }
}
