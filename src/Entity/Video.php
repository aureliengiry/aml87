<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * App\Entity\Video.
 *
 * @ORM\Entity(repositoryClass="App\Repository\VideoRepository")
 *
 * @ORM\Table(name="videos")
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 *
 * @ORM\DiscriminatorColumn(name="provider", type="string")
 *
 * @ORM\DiscriminatorMap({
 *     "youtube" = "\App\Entity\Video\Youtube",
 *     "dailymotion" = "\App\Entity\Video\Dailymotion"
 * })
 */
abstract class Video
{
    /**
     * @ORM\Id
     *
     * @ORM\Column(name="id_video", type="integer")
     *
     * @ORM\GeneratedValue
     */
    protected ?int $id = null;

    /**
     * @ORM\Column(name="provider_id", type="string", length=50)
     */
    protected string $providerId;

    /**
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    protected ?string $title = null;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Evenement", mappedBy="videos", cascade={"all"})
     */
    protected Collection $evenements;

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setProviderId(string $providerId): self
    {
        $this->providerId = $providerId;

        return $this;
    }

    public function getProviderId(): ?string
    {
        return $this->providerId;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    /* -------------------- GESTION EVENEMENTS LIES ------------------------- */

    public function addEvenement(Evenement $evenement): self
    {
        if ( ! $this->evenements->contains($evenement)) {
            $evenement->addVideo($this);
            $this->evenements[] = $evenement;
        }

        return $this;
    }

    /**
     * Fonction to delete $evenement.
     */
    public function removeEvenement(Evenement $evenement): void
    {
        $this->evenements->removeElement($evenement);
        $evenement->removeVideo($this);
    }

    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function setEvenements(Collection $evenements): self
    {
        $this->evenements = $evenements;

        return $this;
    }
}
