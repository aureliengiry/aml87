<?php

namespace Aml\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Aml\Bundle\UrlRewriteBundle\Utils\Slugger;

/**
 * Aml\Bundle\BlogBundle\Entity\Category
 *
 * @ORM\Table(name="blog_categories")
 * @ORM\Entity(repositoryClass="Aml\Bundle\BlogBundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id_category",type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $system_name
     *
     * @ORM\Column(name="system_name", type="string", length=255,unique=true)
     */
    private $system_name;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var text description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="Article", mappedBy="category")
     * @ORM\JoinColumn(name="id", referencedColumnName="id_article")
     */
    protected $articles;

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
     * Set system_name
     *
     * @param string $systemName
     */
    public function setSystemName($title)
    {
        $slugger = new Slugger();
        $this->system_name = $slugger->slugify($title, '_');

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

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
        $this->setSystemName($name);

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return the $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return the $articles
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     *
     * @param Blog $article
     */
    public function addArticle(Article $article)
    {
        $this->articles[] = $article;

        return $this;
    }

    public function __toString()
    {
        return $this->name ?: 'New Category';
    }


}
