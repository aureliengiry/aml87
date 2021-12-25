<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Entity;

use App\Utils\Slugger;
use Doctrine\ORM\Mapping as ORM;

/**
 * App\Entity\Category.
 *
 * @ORM\Table(name="blog_categories")
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Column(name="id_category",type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(name="system_name", type="string", length=255, unique=true)
     */
    private string $systemName;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private ?string $description = null;

    /**
     * @ORM\OneToMany(targetEntity="Article", mappedBy="category")
     * @ORM\JoinColumn(name="id", referencedColumnName="id_article")
     */
    private iterable $articles = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setSystemName(string $title): self
    {
        $slugger = new Slugger();
        $this->systemName = $slugger->slugify($title, '_');

        return $this;
    }

    public function getSystemName(): string
    {
        return $this->systemName;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        $this->setSystemName($name);

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getArticles(): iterable
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        $this->articles[] = $article;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name ?: 'New Category';
    }
}
