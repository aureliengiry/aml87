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
 * App\Core\Domain\Model\Tag.
 *
 * @ORM\Table(name="blog_tags")
 * @ORM\Entity(repositoryClass="App\Core\Infrastructure\Repository\TagRepository")
 */
class Tag
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_tag", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Post\Domain\Model\Post", inversedBy="tags")
     * @ORM\JoinTable(name="blog_articles_tags",
     *        joinColumns={@ORM\JoinColumn(name="id_tag", referencedColumnName="id_tag")},
     *        inverseJoinColumns={@ORM\JoinColumn(name="id_article", referencedColumnName="id_article")}
     * )
     */
    protected $articles;

    /**
     * @var string
     *
     * @ORM\Column(name="system_name", type="string", length=255)
     */
    private $systemName;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="weight", type="smallint", nullable=true)
     */
    private $weight = 0;

    /**
     * @var string description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description = '';

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
     * Set title.
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        $this->setSystemName($name);

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getName(): name
    {
        return $this->name;
    }

    /**
     * Set weight.
     */
    public function setWeight(int $weight): self
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
    public function setSystemName(string $systemName): self
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

    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function setArticles(Collection $articles): self
    {
        $this->articles = $articles;

        return $this;
    }

    public function addArticle(Post $post): void
    {
        $this->articles[] = $post;
    }

    /**
     * Fonction pour supprimer article associé.
     */
    public function removeArticle(Post $post): void
    {
        $this->articles->removeElement($post);
    }

    /**
     * @return string $description
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name ? $this->name : 'New Tag';
    }
}
