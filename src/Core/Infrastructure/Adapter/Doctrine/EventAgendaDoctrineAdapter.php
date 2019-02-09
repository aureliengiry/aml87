<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Core\Infrastructure\Adapter\Doctrine;

use App\Agenda\Domain\EvenementRepositoryInterface;
use App\Agenda\Domain\Exception\EventNotFoundException;
use App\Agenda\Domain\Model\Evenement;
use App\Agenda\Domain\Model\Season;
use App\Agenda\Infrastructure\Doctrine\EvenementDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class EventAgendaDoctrineAdapter.
 */
class EventAgendaDoctrineAdapter implements EvenementRepositoryInterface
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    private function getEvenementRepository(): EvenementDoctrineRepository
    {
        return $this->em->getRepository(Evenement::class);
    }

    public function getAllEventsBySeason(Season $season): iterable
    {
        return $this->getEvenementRepository()->findBySeason($season);
    }

    public function getPublicEventsBySeason(Season $season): iterable
    {
        return $this->getEvenementRepository()->getNextEvenements([
            'public' => Evenement::EVENT_PUBLIC,
            'archive' => Evenement::EVENT_NOT_ARCHIVED,
            'type' => Evenement::EVENEMENT_TYPE_CONCERT,
        ]);
    }

    public function getArchivedConcertBySeason(Season $season): iterable
    {
        return $this->getEvenementRepository()->findArchivedConcertBySeason($season);
    }

    public function getEventBySlug(string $slug): Evenement
    {
        if (\is_numeric($slug)) {
            $article = $this->getEvenementRepository()->find($slug);
        } else {
            $article = $this->getEvenementRepository()->getEventByUrlKey($slug);
        }

        if (null === $article) {
            throw new EventNotFoundException(\sprintf('Event with slug "%s" not found', $slug));
        }

        return $article;
    }

    public function getNextConcert(): ?Evenement
    {
        return $this->getEvenementRepository()->findNextConcert();
    }
}
