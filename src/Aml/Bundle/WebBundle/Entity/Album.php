<?php

namespace Aml\Bundle\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Aml\Bundle\WebBundle\Entity\Album
 *
 * @ORM\Table(name="discography_albums")
 * @ORM\Entity(repositoryClass="Aml\Bundle\WebBundle\Repository\AlbumRepository")
 */
class Album
{
    const ALBUM_IS_PUBLIC = 1;
    const ALBUM_IS_PRIVATE = 2;
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
     * @var string url
     *
     * @ORM\OneToOne(targetEntity="\Aml\Bundle\WebBundle\Entity\Url", cascade={"all"})
     * @ORM\JoinColumn(name="id_url", referencedColumnName="id_url")
     */
    private $url;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

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
     * @ORM\OneToOne(targetEntity="\Aml\Bundle\WebBundle\Entity\Image", inversedBy="album" ,cascade={"all"})
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
     * Set title
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
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
     * @return mixed
     */
    public function getTracks()
    {
        return $this->tracks;
    }

    /**
     * @param mixed $tracks
     */
    public function setTracks($tracks)
    {
        $this->tracks = $tracks;

        return $this;
    }

    /**
     *
     * @param Track $track
     */
    public function addTrack(Track $track)
    {
        $this->tracks[] = $track;

        return $this;
    }

    /**
     * Fonction to delete tag
     * @param Discussion $discussion
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