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
 *
 * @ORM\Entity(repositoryClass="App\Repository\SeasonRepository")
 */
class Season implements \Stringable
{
    /**
     * @var string
     */
    final public const SEASON_DEFAULT_DATE_START = '%s-09-01';

    /**
     * @var string
     */
    final public const SEASON_DEFAULT_DATE_END = '%s-08-31';

    /**
     * @ORM\Column(name="id_season", type="integer")
     *
     * @ORM\Id
     *
     * @ORM\GeneratedValue
     */
    private ?int $id = null;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(name="date_start", type="datetime")
     */
    private \DateTime $dateStart;

    /**
     * @ORM\Column(name="date_end", type="datetime")
     */
    private \DateTime $dateEnd;

    /**
     * @ORM\OneToMany(targetEntity="Evenement", mappedBy="season")
     *
     * @ORM\JoinColumn(name="id", referencedColumnName="id_evenement")
     *
     * @var \Doctrine\Common\Collections\Collection<\App\Entity\Evenement>
     */
    protected \Doctrine\Common\Collections\Collection $evenements;

    public function getDateEnd(): \DateTime
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTime $dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getDateStart(): \DateTime
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTime $dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /* ----------- EVENEMENTS ------------ */

    public function getEvenements()
    {
        return $this->evenements;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection&\App\Entity\Evenement[] $evenements
     */
    public function setEvenements($evenements)
    {
        $this->evenements = $evenements;

        return $this;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection&\App\Entity\Evenement[] $evenement
     */
    public function addEvenement($evenement)
    {
        $this->evenements[] = $evenement;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id)
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name ?: 'New Season';
    }

    public function createStartDate($year): \DateTime
    {
        $str = sprintf(self::SEASON_DEFAULT_DATE_START, $year);

        return new \DateTime($str);
    }

    public function __construct()
    {
        $this->evenements = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
