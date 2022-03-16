<?php

declare(strict_types=1);

/**
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'partenaires')]
#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: \App\Repository\PartenaireRepository::class)]
class Partenaire implements \Stringable
{
    #[ORM\Column(name: 'id_partenaire', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private ?int $id = null;

    #[ORM\Column(name: 'name', type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(name: 'url', type: 'string', length: 255)]
    private string $url;

    #[ORM\OneToOne(targetEntity: \App\Entity\Image::class, cascade: ['all'])]
    #[ORM\JoinColumn(name: 'id_media', referencedColumnName: 'id_media')]
    private Image $logo;

    #[ORM\Column(name: 'description', type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: \App\Entity\Evenement::class, inversedBy: 'partenaires')]
    #[ORM\JoinTable(name: 'evenements_partenaires', joinColumns: [new ORM\JoinColumn(name: 'id_partenaire', referencedColumnName: 'id_partenaire')], inverseJoinColumns: [new ORM\JoinColumn(name: 'id_evenement', referencedColumnName: 'id_evenement')])]
    protected Collection $evenements;

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setLogo($logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getLogo(): Image
    {
        return $this->logo;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /* -------------------- GESTION EVENEMENTS LIES ------------------------- */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function setEvenements(Collection $evenements): self
    {
        $this->evenements = $evenements;

        return $this;
    }

    public function addEvenement(Evenement $evenement): void
    {
        $this->evenements[] = $evenement;
    }

    /**
     * Fonction pour supprimer une discussion d'un mot clé.
     */
    public function removeEvenement(Evenement $evenement): void
    {
        $this->evenements->removeElement($evenement);
    }

    public function __toString(): string
    {
        return $this->name ?: 'Nouveau Partenaire';
    }
}
