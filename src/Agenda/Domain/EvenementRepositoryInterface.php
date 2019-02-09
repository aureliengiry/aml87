<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Agenda\Domain;

use App\Agenda\Domain\Model\Evenement;
use App\Agenda\Domain\Model\Season;

interface EvenementRepositoryInterface
{
    public function getAllEventsBySeason(Season $season): iterable;

    public function getPublicEventsBySeason(Season $season): iterable;

    public function getArchivedConcertBySeason(Season $season): iterable;

    /**
     * @throws \App\Agenda\Domain\Exception\EventNotFoundException
     */
    public function getEventBySlug(string $slug): Evenement;

    public function getNextConcert(): ?Evenement;
}
