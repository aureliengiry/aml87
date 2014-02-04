<?php

namespace Aml\Bundle\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Aml\Bundle\WebBundle\Entity\Link
 *
 * @ORM\Table(name="webbundle_links")
 * @ORM\Entity(repositoryClass="Aml\Bundle\WebBundle\Entity\Repository\LinkRepository")
 */
class Link
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
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
     * @var string $url
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var text description
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    
    /**
     * @var boolean weight
     *
     * @ORM\Column(name="weight", type="integer")
     */
    private $weight = 1;
    
    /**
     * @var boolean $public
     *
     * @ORM\Column(name="public", type="boolean")
     */
    private $public;


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
     * Set url
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
    public function getPublic(){
        return $this->public;
    }
    
	/**
	 * @return the $weight
	 */
	public function getWeight() {
		return $this->weight;
	}

	/**
	 * @param boolean $weight
	 */
	public function setWeight($weight) {
		$this->weight = $weight;
		return $this;
	}
	
	/**
	 * @return the $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param text $description
	 */
	public function setDescription($description) {
		$this->description = $description;
		return $this; 
	}    
    
}