<?php

namespace Aml\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Aml\Bundle\BlogBundle\Entity\Tags
 *
 * @ORM\Table(name="blog_tags")
 * @ORM\Entity(repositoryClass="Aml\Bundle\BlogBundle\Entity\Repository\BlogTagsRepository")
 */
class BlogTags
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id_tag", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    
    /**
     * @ORM\ManyToMany(targetEntity="Blog", inversedBy="tags")
     * @ORM\JoinTable(name="blog_articles_tags",
     * 		joinColumns={@ORM\JoinColumn(name="id_tag", referencedColumnName="id_tag")},
     * 		inverseJoinColumns={@ORM\JoinColumn(name="id_article", referencedColumnName="id_article")}
     * )
     */
    protected $articles;

    
    /**
     * @var string $system_name
     *
     * @ORM\Column(name="system_name", type="string", length=255)
     */
    private $system_name;

    /**
     * @var string $title
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var smallint $weight
     *
     * @ORM\Column(name="weight", type="smallint", nullable=true)
     */
    private $weight = 0;
    
     /**
     * @var text description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description = '';

	public function __construct()
    {
        $this->articles = new ArrayCollection();
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
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set weight
     *
     * @param smallint $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * Get weight
     *
     * @return smallint 
     */
    public function getWeight()
    {
        return $this->weight;
    }
    
    /**
     * Set system_name
     *
     * @param string $systemName
     */
    public function setSystemName($systemName)
    {
        $this->system_name = $this->_build_SystemName($systemName);
        return $this;
    }

    /**
     * Get system_name
     *
     * @return string 
     */
    public function getSystemName()
    {
        return $this->system_name;
    }
    
	public function getArticles()
    {
    	return $this->articles;
    }
    
	public function setArticles($articles)
    {
    	$this->articles = $articles;
    	return $this;
    }
    
    public function addArticle($article)
    {
    	$this->articles[] = $article;
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
	
	/**
     * http://www.ficgs.com/How-to-remove-accents-in-PHP-f3057.html
     */
    protected function _build_SystemName($string)
    {   	
    	/**
	     * http://www.ficgs.com/How-to-remove-accents-in-PHP-f3057.html
	     */
        $string = str_replace( array('à','á','â','ã','ä', 'ç', 'è','é','ê','ë', 'ì','í','î','ï', 'ñ', 'ò','ó','ô','õ','ö', 'ù','ú','û','ü', 'ý','ÿ', 'À','Á','Â','Ã','Ä', 'Ç', 'È','É','Ê','Ë', 'Ì','Í','Î','Ï', 'Ñ', 'Ò','Ó','Ô','Õ','Ö', 'Ù','Ú','Û','Ü', 'Ý'), array('a','a','a','a','a', 'c', 'e','e','e','e', 'i','i','i','i', 'n', 'o','o','o','o','o', 'u','u','u','u', 'y','y', 'A','A','A','A','A', 'C', 'E','E','E','E', 'I','I','I','I', 'N', 'O','O','O','O','O', 'U','U','U','U', 'Y'), $string);
        $string = str_replace(array(' ','-'), array('_','_'),$string);
        
        return strtolower($string);
    } 

    
    
}
