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
 * App\Entity\Album.
 *
 * @ORM\Table(name="discography_albums")
 * @ORM\Entity(repositoryClass="App\Repository\AlbumRepository")
 */
class Album implements \Stringable
{
    final public const ALBUM_IS_PUBLIC = 1;
    final public const ALBUM_IS_PRIVATE = 2;

    /**
     * @ORM\Column(name="id_album", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(name="title", type="string", length=255)
     */
    private string $title;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Url", cascade={"all"})
     * @ORM\JoinColumn(name="id_url", referencedColumnName="id_url")
     */
    private Url $url;

    /**
     * @ORM\Column(name="description", type="text")
     */
    private string $description;

    /**
     * @ORM\Column(name="public", type="boolean")
     */
    private bool $public;

    /**
     * @ORM\Column(name="date", type="date")
     */
    private \DateTime $date;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Image", inversedBy="album" ,cascade={"all"})
     * @ORM\JoinColumn(name="id_media", referencedColumnName="id_media")
     */
    private ?Image $image = null;

    /**
     * @ORM\OneToMany(targetEntity="Track", mappedBy="album",cascade={"all"})
     * @ORM\JoinColumn(name="id_track", referencedColumnName="id_track")
     *
     * @var Track[]
     */
    private Collection $tracks;

    public function __construct()
    {
        $this->tracks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setUrl(Url $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getUrl(): ?Url
    {
        return $this->url;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setPublic(bool $public): self
    {
        $this->public = $public;

        return $this;
    }

    public function isPublic(): bool
    {
        return $this->public;
    }

    public function setDate(\DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setImage(Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function getTracks(): Collection
    {
        return $this->tracks;
    }

    public function setTracks(Collection $tracks): self
    {
        $this->tracks = $tracks;

        return $this;
    }

    public function addTrack(Track $track): self
    {
        $this->tracks[] = $track;

        return $this;
    }

    public function removeTrack(Track $track): void
    {
        $this->tracks->removeElement($track);
    }

    public function __toString(): string
    {
        return $this->title ?: 'Nouvel Album';
    }
}
