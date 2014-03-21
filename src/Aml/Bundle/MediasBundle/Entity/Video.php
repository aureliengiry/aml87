<?php

namespace Aml\Bundle\MediasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection;

use Aml\Bundle\MediasBundle\Entity\Video\Youtube;
use Aml\Bundle\MediasBundle\Entity\Video\Dailymotion;

/**
 * Aml\Bundle\WebBundle\Entity\Video
 *
 * @ORM\Entity(repositoryClass="Aml\Bundle\MediasBundle\Entity\Repository\VideoRepository")
 *
 *
 * @ORM\Table(name="mediasbundle_videos")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="provider", type="string")
 * @ORM\DiscriminatorMap({"youtube" = "\Aml\Bundle\MediasBundle\Entity\Video\Youtube", "dailymotion" = "\Aml\Bundle\MediasBundle\Entity\Video\Dailymotion"})
 */
class Video 
{
	/**
	 * @ORM\Id
     * @ORM\Column(name="id_video", type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
    protected $id;

    /**
     * @var string $providerId
     *
     * @ORM\Column(name="provider_id", type="string", length=50)
     */
    protected $providerId;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255,nullable=true)
     */
    protected $title;

	public function __construct()
    {
        //$this->articles = new ArrayCollection();
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
     * @param string $providerId
     */
    public function setProviderId($providerId)
    {
        $this->providerId = $providerId;
        return $this;
    }

    /**
     * @return string
     */
    public function getProviderId()
    {
        return $this->providerId;
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




}