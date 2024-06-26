<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Entity;

use App\Utils\Slugger;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * App\Entity\Tags.
 *
 * @ORM\Table(name="blog_tags")
 *
 * @ORM\Entity(repositoryClass="App\Repository\TagsRepository")
 */
class Tags implements \Stringable
{
    /**
     * @ORM\Column(name="id_tag", type="integer")
     *
     * @ORM\Id
     *
     * @ORM\GeneratedValue
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToMany(targetEntity="Article", inversedBy="tags")
     *
     * @ORM\JoinTable(name="blog_articles_tags",
     *        joinColumns={@ORM\JoinColumn(name="id_tag", referencedColumnName="id_tag")},
     *        inverseJoinColumns={@ORM\JoinColumn(name="id_article", referencedColumnName="id_article")}
     * )
     *
     * @var \Doctrine\Common\Collections\Collection<\App\Entity\Article>
     */
    protected \Doctrine\Common\Collections\Collection $articles;

    /**
     * @ORM\Column(name="system_name", type="string", length=255)
     */
    private string $systemName;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(name="weight", type="smallint", nullable=true)
     */
    private int $weight = 0;

    /**
     * @var string description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private string $description = '';

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    /**
     * Get id.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set title.
     */
    public function setName(string $name)
    {
        $this->name = $name;
        $this->setSystemName($name);

        return $this;
    }

    /**
     * Get title.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set weight.
     */
    public function setWeight(int $weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight.
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * Set system_name.
     */
    public function setSystemName(string $systemName)
    {
        $slugger = new Slugger();
        $this->systemName = $slugger->slugify($systemName, '_');

        return $this;
    }

    /**
     * Get system_name.
     */
    public function getSystemName(): string
    {
        return $this->systemName;
    }

    public function getArticles(): \Doctrine\Common\Collections\Collection
    {
        return $this->articles;
    }

    public function setArticles(\Doctrine\Common\Collections\Collection $articles)
    {
        $this->articles = $articles;

        return $this;
    }

    public function addArticle(Article $article): void
    {
        $this->articles[] = $article;
    }

    /**
     * Fonction pour supprimer article associé.
     */
    public function removeArticle(Article $article): void
    {
        $this->articles->removeElement($article);
    }

    /**
     * @return string $description
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name ?: 'New Tag';
    }
}
