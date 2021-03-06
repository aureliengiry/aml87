<?php

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
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set number.
     *
     * @param int $number
     *
     * @return Track
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number.
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Track
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set composer.
     *
     * @param string $composer
     *
     * @return Track
     */
    public function setComposer($composer)
    {
        $this->composer = $composer;

        return $this;
    }

    /**
     * Get composer.
     *
     * @return string
     */
    public function getComposer()
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
    public function setAlbum($album)
    {
        $this->album = $album;

        return $this;
    }

    /**
     * Get album.
     *
     * @return int
     */
    public function getAlbum()
    {
        return $this->album;
    }

    public function __toString()
    {
        return $this->title ? $this->title : 'New Track';
    }
}
