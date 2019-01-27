<?php
namespace App\Agenda;

use App\Entity\Season;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class SeasonManager
 * @package App\Agenda
 */
class SeasonManager
{
    /**
     * @var ObjectManager
     */
    private $em;


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

    public function getPastSeasons(){
        return $this->getSeasonRepository()->getPastSeasons();
    }
}
