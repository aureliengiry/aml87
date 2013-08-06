<?php

namespace Aml\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Aml\Bundle\BlogBundle\Entity\Blog
 *
 * @ORM\Table(name="blog_articles")
 * @ORM\Entity(repositoryClass="Aml\Bundle\BlogBundle\Entity\Repository\BlogRepository")
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
     * @ORM\OneToOne(targetEntity="\Aml\Bundle\MediasBundle\Entity\Image", inversedBy="articleBlog" ,cascade={"all"})
     * @ORM\JoinColumn(name="id_media", referencedColumnName="id_media")
     */
    private $logo;

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

    /**
     * @ORM\ManyToMany(targetEntity="\Aml\Bundle\EvenementsBundle\Entity\Evenement", inversedBy="articlesBlog")
     * @ORM\JoinTable(name="evenements_articles_blog",
     * 		joinColumns={@ORM\JoinColumn(name="id_article", referencedColumnName="id_article")},
     * 		inverseJoinColumns={@ORM\JoinColumn(name="id_evenement", referencedColumnName="id_evenement")}
     * )
     */
    protected $evenements;

 	public function __construct()
    {
      //  var_dump(__METHOD__,$this->get);
        //exit;
        $this->tags = new ArrayCollection();
        $this->evenements = new ArrayCollection();
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
        $this->setUrl();
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
     * Set logo
     *
     * @param string $logo
     * @return Partenaire
     */
    public function setLogo( $logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
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
    public function setCreated(\DateTime $created=null)
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
    public function setUpdated(\DateTime $updated = null)
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
	 * @param datetime $published
	 */
	public function setPublished($published) {
		$this->published = $published;
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

    /**
     *
     * @param TumblrTag $tag
     */
    public function addTag($tag) {
        if (!$this->tags->contains($tag)) {
            $tag->addArticle($this);
            $this->tags[] = $tag;
        }
        return $this;
    }

    /**
     * Fonction to delete tag
     * @param Discussion $discussion
     */
    public function removeTag($tag)
    {
        $this->tags->removeElement($tag);
        $tag->deleteArticle($this);
    }

    /**
     * @return the $tags
     */
    public function getTags() {
        return $this->tags;
    }

    /**
     * @return the $tags
     */
    public function setTags(ArrayCollection $tags) {
        $this->tags = $tags;
        return $this;
    }

    /* -------------------- GESTION EVENEMENTS LIES ------------------------- */
    public function getEvenements()
    {
        return $this->evenements;
    }

    public function setEvenements($evenements)
    {
        $this->evenements = $evenements;
        return $this;
    }

    public function addEvenement($evenement)
    {
        $this->evenements[] = $evenement;
    }

}