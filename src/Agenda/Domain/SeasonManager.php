<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Agenda\Domain;

use App\Agenda\Domain\Model\Season;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class SeasonManager.
 */
class SeasonManager
{
    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * SeasonManager constructor.
     */
    public function __construct(ObjectManager $entityManager)
    {
        $this->em = $entityManager;
    }

    private function getSeasonRepository()
    {
        return $this->em->getRepository(Season::class);
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
