<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Agenda\Domain\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * App\Core\Domain\Model\Season.
 *
 * @ORM\Table(name="evenements_seasons")
 * @ORM\Entity(repositoryClass="App\Agenda\Infrastructure\Doctrine\SeasonDoctrineRepository")
 */
class Season
{
    const SEASON_DEFAULT_DATE_START = '%s-09-01';
    const SEASON_DEFAULT_DATE_END = '%s-08-31';

    /**
     * @var int
     *
     * @ORM\Column(name="id_season", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_start", type="datetime")
     */
    private $dateStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_end", type="datetime")
     */
    private $dateEnd;

    /**
     * @ORM\OneToMany(targetEntity="Evenement", mappedBy="season")
     * @ORM\JoinColumn(name="id", referencedColumnName="id_evenement")
     */
    protected $evenements;

    /**
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * @param \DateTime $dateEnd
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * @param \DateTime $dateStart
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /* ----------- EVENEMENTS ------------ */

    public function getEvenements()
    {
        return $this->evenements;
    }

    public function setEvenements($evenements)
    {
        $this->evenements = $evenements;

        return $this;
    }

    /**
     * @param Evenement $evenement
     */
    public function addEvenement($evenement)
    {
        $this->evenements[] = $evenement;

        return $this;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name ? $this->name : 'New Season';
    }

    public function createStartDate($year)
    {
        $str = \sprintf(self::SEASON_DEFAULT_DATE_START, $year);

        return new \DateTime($str);
    }
}
