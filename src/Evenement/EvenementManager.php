<?php

namespace App\Evenement;

use App\Entity\Evenement;
use App\Entity\Season;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class EvenementManager.
 */
class EvenementManager
{
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ObjectManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getPublicEventsInCurrentSeason()
    {
        return $this->getEventRepository()->getNextEvenements([
            'public' => 1,
            'archive' => 0,
            'type' => Evenement::EVENEMENT_TYPE_CONCERT,
        ]);
    }

    public function getEventByIdOrUrl(string $urlKey)
    {
        if (is_int($urlKey)) {
            return $this->getEventRepository()->find($urlKey);
        } else {
            return $this->getEventRepository()->getEventByUrlKey($urlKey);
        }
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
