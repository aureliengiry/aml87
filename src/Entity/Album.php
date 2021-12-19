<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * App\Entity\Album.
 *
 * @ORM\Table(name="discography_albums")
 * @ORM\Entity(repositoryClass="App\Repository\AlbumRepository")
 */
class Album
{
    public const ALBUM_IS_PUBLIC = 1;
    public const ALBUM_IS_PRIVATE = 2;
    /**
     * @var int
     *
     * @ORM\Column(name="id_album", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private ?int $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string url
     *
     * @ORM\OneToOne(targetEntity="\App\Entity\Url", cascade={"all"})
     * @ORM\JoinColumn(name="id_url", referencedColumnName="id_url")
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="public", type="boolean")
     */
    private $public;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Image", inversedBy="album" ,cascade={"all"})
     * @ORM\JoinColumn(name="id_media", referencedColumnName="id_media")
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="Track", mappedBy="album",cascade={"all"})
     * @ORM\JoinColumn(name="id_track", referencedColumnName="id_track")
     */
    private $tracks;

    public function __construct()
    {
        $this->tracks = new ArrayCollection();
    }

    /**
     * Get id.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set title.
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set title.
     *
     * @param string $url
     */
    public function setUrl(Url $url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url.
     *
     * @return string
     */
    public function getUrl(): ?Url
    {
        return $this->url;
    }

    /**
     * Set description.
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set public.
     */
    public function setPublic(bool $public)
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Is public.
     */
    public function isPublic(): bool
    {
        return $this->public;
    }

    /**
     * Set date.
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * Set image.
     *
     * @param string $image
     *
     * @return Album
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image.
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return ArrayCollection
     */
    public function getTracks()
    {
        return $this->tracks;
    }

    /**
     * @param ArrayCollection $tracks
     */
    public function setTracks($tracks)
    {
        $this->tracks = $tracks;

        return $this;
    }

    public function addTrack(Track $track)
    {
        $this->tracks[] = $track;

        return $this;
    }

    /**
     * Fonction to delete tag.
     */
    public function removeTrack(Track $track)
    {
        $this->tracks->removeElement($track);
    }

    public function __toString()
    {
        return $this->title ? $this->title : 'Nouvel Album';
    }
}
