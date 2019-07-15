<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Core\Domain\Model;

use App\Core\Domain\Utils\Slugger;
use App\Post\Domain\Model\Post;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * App\Core\Domain\Model\Category.
 *
 * @ORM\Table(name="blog_categories")
 * @ORM\Entity(repositoryClass="App\Core\Infrastructure\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_category",type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="system_name", type="string", length=255, unique=true)
     */
    private $systemName;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Post\Domain\Model\Post", mappedBy="category")
     * @ORM\JoinColumn(name="id", referencedColumnName="id_article")
     */
    protected $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set system_name.
     */
    public function setSystemName(string $title): self
    {
        $slugger = new Slugger();
        $this->systemName = $slugger->slugify($title, '_');

        return $this;
    }

    /**
     * Get system_name.
     */
    public function getSystemName(): string
    {
        return $this->systemName;
    }

    /**
     * Set name.
     */
    public function setName(string $name)
    {
        $this->name = $name;
        $this->setSystemName($name);

        return $this;
    }

    /**
     * Get name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string $description
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return $this
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Post $post): self
    {
        $this->articles[] = $post;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name ?: 'New Category';
    }
}
