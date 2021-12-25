<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * App\Entity\Season.
 *
 * @ORM\Table(name="evenements_seasons")
 * @ORM\Entity(repositoryClass="App\Repository\SeasonRepository")
 */
class Season
{
    public const SEASON_DEFAULT_DATE_START = '%s-09-01';
    public const SEASON_DEFAULT_DATE_END = '%s-08-31';

    /**
     * @var int
     *
     * @ORM\Column(name="id_season", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private ?int $id;

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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function __toString()
    {
        return $this->name ? $this->name : 'New Season';
    }

    public function createStartDate($year)
    {
        $str = sprintf(self::SEASON_DEFAULT_DATE_START, $year);

        return new \DateTime($str);
    }
}
