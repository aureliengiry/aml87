<?php

namespace Aml\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Aml\Bundle\UrlRewriteBundle\Utils\Slugger;

/**
 * Aml\Bundle\BlogBundle\Entity\Tags
 *
 * @ORM\Table(name="blog_tags")
 * @ORM\Entity(repositoryClass="Aml\Bundle\BlogBundle\Entity\Repository\TagsRepository")
 */
class Tags
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
     * @ORM\ManyToMany(targetEntity="Article", inversedBy="tags")
     * @ORM\JoinTable(name="blog_articles_tags",
     *        joinColumns={@ORM\JoinColumn(name="id_tag", referencedColumnName="id_tag")},
     *        inverseJoinColumns={@ORM\JoinColumn(name="id_article", referencedColumnName="id_article")}
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
        $this->setSystemName($name);

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
        $slugger = new Slugger();
        $this->system_name = $slugger->slugify($systemName, '_');

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

    public function addArticle(Article $article)
    {
        $this->articles[] = $article;
    }

    /**
     * Fonction pour supprimer une discussion d'un mot clé
     *
     * @param Discussion $discussion
     */
    public function removeArticle(Article $article)
    {
        $this->articles->removeElement($article);
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


    public function __toString()
    {
        return $this->name ? $this->name : 'New Tag';
    }
}
