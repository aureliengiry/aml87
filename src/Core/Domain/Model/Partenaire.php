<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Core\Domain\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Partenaire.
 *
 * @ORM\Table(name="partenaires")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="App\Core\Infrastructure\Repository\PartenaireRepository")
 */
class Partenaire
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_partenaire", type="integer")
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
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @ORM\OneToOne(targetEntity="\App\Media\Domain\Model\Image", cascade={"all"})
     * @ORM\JoinColumn(name="id_media", referencedColumnName="id_media")
     */
    private $logo;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Agenda\Domain\Model\Evenement", inversedBy="partenaires")
     * @ORM\JoinTable(name="evenements_partenaires",
     *        joinColumns={@ORM\JoinColumn(name="id_partenaire", referencedColumnName="id_partenaire")},
     *        inverseJoinColumns={@ORM\JoinColumn(name="id_evenement", referencedColumnName="id_evenement")}
     * )
     */
    protected $evenements;

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     *
     * @return Partenaire
     */
    public function setName(string $name): self
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
     *
     * @return Partenaire
     */
    public function setUrl(string $url): self
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
    public function setLogo($logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo.
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set description.
     *
     *
     * @return Partenaire
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /* -------------------- GESTION EVENEMENTS LIES ------------------------- */
    public function getEvenements(): iterable
    {
        return $this->evenements;
    }

    public function setEvenements(iterable $evenements): self
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
