<?php

namespace Aml\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Aml\Bundle\BlogBundle\Entity\Category
 *
 * @ORM\Table(name="blog_categories")
 * @ORM\Entity(repositoryClass="Aml\Bundle\BlogBundle\Entity\Repository\CategoryRepository")
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
        $this->system_name = $this->_build_SystemName($title);
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
     * http://www.ficgs.com/How-to-remove-accents-in-PHP-f3057.html
     */
    protected function _build_SystemName($string)
    {
        /**
         * http://www.ficgs.com/How-to-remove-accents-in-PHP-f3057.html
         */
        $string = str_replace(array('à', 'á', 'â', 'ã', 'ä', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý'), array('a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y'), $string);
        $string = str_replace(array(' ', '-'), array('_', '_'), $string);

        return strtolower($string);
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
    public function addArticle($article)
    {
        $this->articles[] = $article;
        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }


}