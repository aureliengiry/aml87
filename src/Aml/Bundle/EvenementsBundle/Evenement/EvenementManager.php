<?php

namespace Aml\Bundle\EvenementsBundle\Evenement;

use Aml\Bundle\EvenementsBundle\Entity\Evenement;
use Doctrine\ORM\EntityManagerInterface;

class EvenementManager
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getPublicEventsInCurrentSeason()
    {
        return $this->getEventepository()->getNextEvenements(
            [
                'public'  => 1,
                'archive' => 0,
                'type'    => Evenement::EVENEMENT_TYPE_CONCERT,
            ]
        );
    }

    public function getEventByIdOrUrl($urlKey)
    {
        if (is_int($urlKey)) {
            return $this->getEventepository()->find($urlKey);
        } else {
            return $this->getEventepository()->getEventByUrlKey($urlKey);
        }
    }

    private function getEventepository()
    {
        return $this->em->getRepository(Evenement::class);
    }
}
