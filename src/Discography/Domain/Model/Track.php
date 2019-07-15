<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Discography\Domain\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Track.
 *
 * @ORM\Table(name="discography_tracks")
 * @ORM\Entity(repositoryClass="App\Discography\Infrastructure\Doctrine\TrackDoctrineRepository")
 */
class Track
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_track", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="number", type="smallint")
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="composer", type="string", length=255)
     */
    private $composer;

    /**
     * @var string url
     *
     * @ORM\ManyToOne(targetEntity="Album", inversedBy="tracks")
     * @ORM\JoinColumn(name="id_album", referencedColumnName="id_album")
     */
    private $album;

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
     * Set number.
     *
     *
     * @return Track
     */
    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number.
     *
     * @return int
     */
    public function getNumber(): ?int
    {
        return $this->number;
    }

    /**
     * Set title.
     *
     *
     * @return Track
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set composer.
     *
     *
     * @return Track
     */
    public function setComposer(string $composer): self
    {
        $this->composer = $composer;

        return $this;
    }

    /**
     * Get composer.
     *
     * @return string
     */
    public function getComposer(): ?string
    {
        return $this->composer;
    }

    /**
     * Set album.
     *
     * @param int $album
     *
     * @return Track
     */
    public function setAlbum(Album $album): self
    {
        $this->album = $album;

        return $this;
    }

    /**
     * Get album.
     *
     * @return int
     */
    public function getAlbum(): Album
    {
        return $this->album;
    }

    public function __toString(): string
    {
        return $this->title ? $this->title : 'New Track';
    }
}
