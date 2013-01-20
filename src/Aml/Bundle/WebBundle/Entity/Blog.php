<?php

namespace Aml\Bundle\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Aml\Bundle\WebBundle\Entity\Blog
 *
 * @ORM\Table(name="blog_articles")
 * @ORM\Entity(repositoryClass="Aml\Bundle\WebBundle\Entity\Repository\BlogRepository")
 */
class Blog
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id_article", type="integer")
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
     * @ORM\Column(name="url", type="string", length=255,unique=true)
     */
    private $url;

    /**
     * @var text $body
     *
     * @ORM\Column(name="body", type="text")
     */
    private $body;

    /**
     * @var datetime $created
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var datetime $updated
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;
    
    /**
     * @var datetime $published
     *
     * @ORM\Column(name="published", type="datetime",nullable=true)
     */
    private $published;

    /**
     * @var boolean $public
     *
     * @ORM\Column(name="public", type="boolean")
     */
    private $public;
    	
	/**
     * @ORM\ManyToOne(targetEntity="BlogCategories", inversedBy="articles")
     * @ORM\JoinColumn(name="id_blog_category", referencedColumnName="id_blog_category")
     */
    protected $category;

// 	/**
// 	 * @ORM\ManyToMany(targetEntity="File", mappedBy="articles", cascade={"persist"})
// 	 */
// 	protected $files;
	
	/**
	 * @ORM\ManyToMany(targetEntity="BlogTags", mappedBy="articles", cascade={"persist"})
	 */
	protected $tags;

 	public function __construct()
    {
        $this->tags = new ArrayCollection();
       // $this->files = new ArrayCollection();
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
    public function setUrl()
    {
        $this->url = $this->_build_SystemName($this->title);
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
     * Set body
     *
     * @param text $body
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * Get body
     *
     * @return text 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set created
     *
     * @param datetime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * Get created
     *
     * @return datetime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param datetime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * Get updated
     *
     * @return datetime 
     */
    public function getUpdated()
    {
        return $this->updated;
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
	 * @return the $published
	 */
	public function getPublished() {
		return $this->published;
	}

	/**
	 * @return the $tags
	 */
	public function getTags() {
		return $this->tags;
	}

	/**
	 * @param datetime $published
	 */
	public function setPublished($published) {
		$this->published = $published;
		return $this;
	}


	/**
	 * @param field_type $tags
	 */
	public function setTags($tags) {
		$this->tags[] = $tags;
		return $this;
	}

	/**
	 * @return the $id_blog_category
	 */
	public function getCategory() {
		return $this->category;
	}

	/**
	 * @param field_type $id_blog_category
	 */
	public function setCategory($id_blog_category) {
		$this->category = $id_blog_category;
		return $this;
	}

	
	/**
	 *
	 * @param MotCle $mot
	 */
	public function addTags($tag) {
		$tag->addArticle($this);
		$this->tags[] = $tag;
		return $this;
	}
	
// 	/**
// 	 *
// 	 * @param File $file
// 	 */
// 	public function addFiles($file) {
// 		$tag->addArticle($this);
// 		$this->files[] = $file;
// 		return $this;
// 	}

// 	/**
// 	 * @return the $files
// 	 */
// 	public function getFiles() {
// 		return $this->files;
// 	}
    
    
    
	/**
	 * http://www.ficgs.com/How-to-remove-accents-in-PHP-f3057.html
	 */
	protected function _build_SystemName($string)
	{
		/**
		 * http://www.ficgs.com/How-to-remove-accents-in-PHP-f3057.html
		 */
		$string = str_replace( array('à','á','â','ã','ä', 'ç', 'è','é','ê','ë', 'ì','í','î','ï', 'ñ', 'ò','ó','ô','õ','ö', 'ù','ú','û','ü', 'ý','ÿ', 'À','Á','Â','Ã','Ä', 'Ç', 'È','É','Ê','Ë', 'Ì','Í','Î','Ï', 'Ñ', 'Ò','Ó','Ô','Õ','Ö', 'Ù','Ú','Û','Ü', 'Ý'), array('a','a','a','a','a', 'c', 'e','e','e','e', 'i','i','i','i', 'n', 'o','o','o','o','o', 'u','u','u','u', 'y','y', 'A','A','A','A','A', 'C', 'E','E','E','E', 'I','I','I','I', 'N', 'O','O','O','O','O', 'U','U','U','U', 'Y'), $string);
		$string = str_replace(array(' ','-','/','?'), array('_','_','_',''),$string);
	
		return strtolower($string);
	}
    
}