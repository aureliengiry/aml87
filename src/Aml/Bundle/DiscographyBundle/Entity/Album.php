<?php

namespace Aml\Bundle\DiscographyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Aml\Bundle\DiscographyBundle\Entity\Album
 *
 * @ORM\Table(name="discography_albums")
 * @ORM\Entity(repositoryClass="Aml\Bundle\DiscographyBundle\Entity\Repository\AlbumRepository")
 */
class Album
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id_album", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var array $titres
     *
     * @ORM\Column(name="titres", type="array")
     */
    private $titres;

    /**
     * @var boolean $public
     *
     * @ORM\Column(name="public", type="boolean")
     */
    private $public;

    /**
     * @var date $date
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @ORM\OneToOne(targetEntity="\Aml\Bundle\MediasBundle\Entity\Image", inversedBy="album" ,cascade={"all"})
     * @ORM\JoinColumn(name="id_media", referencedColumnName="id_media")
     */
    private $image;

    /**
     * @var text $tracks
     *
     * @ORM\Column(name="tracks", type="text")
     */
    private $tracks;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set titres
     *
     * @param array $titres
     */
    public function setTitres($titres)
    {
        $this->titres = $titres;
        return $this;
    }

    /**
     * Get titres
     *
     * @return array 
     */
    public function getTitres()
    {
        return $this->titres;
    }

    /**
     * Set public
     *
     * @param boolean $public
     */
    public function setPublic($public)
    {
        $this->public = $public;
        return $this;
    }

    /**
     * Get public
     *
     * @return boolean 
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * Set date
     *
     * @param date $date
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Get date
     *
     * @return date 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Album
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param \Aml\Bundle\DiscographyBundle\Entity\text $tracks
     */
    public function setTracks($tracks)
    {
        $this->tracks = $tracks;
    }

    /**
     * @return \Aml\Bundle\DiscographyBundle\Entity\text
     */
    public function getTracks()
    {
        return $this->tracks;
    }

    public function __toString()
    {
        return $this->title ? : 'New Album';
    }
}