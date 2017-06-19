<?php

namespace Aml\Bundle\EvenementsBundle\Evenement;


use Aml\Bundle\EvenementsBundle\Entity\Evenement;
use Doctrine\ORM\EntityManager;

class EvenementManager
{
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }
    public function findAllConcerts(){
        return $this->getEvenementRepository()->findAllConcerts();
    }

    public function getEvenementRepository(){
        return $this->em->getRepository(Evenement::class);
    }
}
