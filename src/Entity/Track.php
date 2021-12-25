<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Track.
 *
 * @ORM\Table(name="discography_tracks")
 * @ORM\Entity(repositoryClass="App\Repository\TrackRepository")
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
    private ?int $id = null;

    /**
     * @ORM\Column(name="number", type="smallint")
     */
    private int $number;

    /**
     * @ORM\Column(name="title", type="string", length=255)
     */
    private string $title;

    /**
     * @ORM\Column(name="composer", type="string", length=255)
     */
    private string $composer;

    /**
     * @ORM\ManyToOne(targetEntity="Album", inversedBy="tracks")
     * @ORM\JoinColumn(name="id_album", referencedColumnName="id_album")
     */
    private Album $album;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function setTitle($title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setComposer(string $composer): self
    {
        $this->composer = $composer;

        return $this;
    }

    public function getComposer(): string
    {
        return $this->composer;
    }

    public function setAlbum(Album $album): self
    {
        $this->album = $album;

        return $this;
    }

    public function getAlbum(): Album
    {
        return $this->album;
    }

    public function __toString(): string
    {
        return $this->title ?: 'New Track';
    }
}
