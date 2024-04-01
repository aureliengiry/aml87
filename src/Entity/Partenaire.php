<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Partenaire.
 *
 * @ORM\Table(name="webbundle_partenaires")
 *
 * @ORM\HasLifecycleCallbacks
 *
 * @ORM\Entity(repositoryClass="App\Repository\PartenaireRepository")
 */
class Partenaire implements \Stringable
{
    /**
     * @ORM\Column(name="id_partenaire", type="integer")
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
     * @ORM\Column(name="url", type="string", length=255)
     */
    private string $url;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Image", cascade={"all"})
     *
     * @ORM\JoinColumn(name="id_media", referencedColumnName="id_media")
     */
    private ?Image $logo = null;

    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private string $description;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Evenement", inversedBy="partenaires")
     *
     * @ORM\JoinTable(name="evenements_partenaires",
     *        joinColumns={@ORM\JoinColumn(name="id_partenaire", referencedColumnName="id_partenaire")},
     *        inverseJoinColumns={@ORM\JoinColumn(name="id_evenement", referencedColumnName="id_evenement")}
     * )
     *
     * @var \Doctrine\Common\Collections\Collection<\App\Entity\Evenement>
     */
    protected \Doctrine\Common\Collections\Collection $evenements;

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
    }

    /**
     * Get id.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @return Partenaire
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set url.
     *
     * @return Partenaire
     */
    public function setUrl(string $url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url.
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Set logo.
     *
     * @param string $logo
     *
     * @return Partenaire
     */
    public function setLogo(?Image $logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo.
     *
     * @return string
     */
    public function getLogo(): ?Image
    {
        return $this->logo;
    }

    /**
     * Set description.
     *
     * @return Partenaire
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /* -------------------- GESTION EVENEMENTS LIES ------------------------- */
    public function getEvenements(): \Doctrine\Common\Collections\Collection
    {
        return $this->evenements;
    }

    public function setEvenements(\Doctrine\Common\Collections\Collection $evenements)
    {
        $this->evenements = $evenements;

        return $this;
    }

    public function addEvenement($evenement): void
    {
        $this->evenements[] = $evenement;
    }

    /**
     * Fonction pour supprimer une discussion d'un mot clé.
     */
    public function removeEvenement($evenement): void
    {
        $this->evenements->removeElement($evenement);
    }

    public function __toString(): string
    {
        return $this->name ?: 'Nouveau Partenaire';
    }
}
