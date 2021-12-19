<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Entity;

use App\Entity\Video\Youtube;
use Doctrine\ORM\Mapping as ORM;

/**
 * App\Entity\Article.
 *
 * @ORM\Table(name="blog_articles")
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    public const ARTICLE_IS_PUBLIC = 1;
    public const ARTICLE_IS_PRIVATE = 0;

    /**
     * @ORM\Column(name="id_article", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private ?int $id;

    /***
     * @ORM\Column(name="title", type="string", length=255)
     */
    private string $title = '';

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\UrlArticle", cascade={"all"}, fetch="EAGER")s
     * @ORM\JoinColumn(name="id_url", referencedColumnName="id_url")
     */
    private UrlArticle $url;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Image", cascade={"all"})
     * @ORM\JoinColumn(name="id_media", referencedColumnName="id_media")
     */
    private ?Image $logo;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Video\Youtube", cascade={"all"})
     * @ORM\JoinColumn(name="id_video", referencedColumnName="id_video")
     */
    private ?Youtube $video;

    /**
     * @ORM\Column(name="body", type="text")
     */
    private string $body;

    /**
     * @ORM\Column(name="created", type="datetime")
     */
    private \DateTime $created;

    /**
     * @ORM\Column(name="updated", type="datetime")
     */
    private \DateTime $updated;

    /**
     * @ORM\Column(name="published", type="datetime", nullable=true)
     */
    private ?\DateTime $published;

    /**
     * @ORM\Column(name="public", type="boolean")
     */
    private bool $public;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="articles")
     * @ORM\JoinColumn(name="id_category", referencedColumnName="id_category")
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity="Tags", mappedBy="articles", cascade={"all"})
     */
    private iterable $tags = [];

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Evenement", mappedBy="articles", cascade={"all"})
     */
    private iterable $evenements = [];

    public function __construct()
    {
        $this->created = $this->updated = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setUrl(UrlArticle $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getUrl(): UrlArticle
    {
        return $this->url;
    }

    public function setLogo(Image $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getLogo(): ?Image
    {
        return $this->logo;
    }

    public function setVideo(Youtube $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getVideo(): ?Youtube
    {
        return $this->video;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getCreated(): ?\DateTime
    {
        return $this->created;
    }

    public function setUpdated(\DateTime $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    public function getUpdated(): ?\DateTime
    {
        return $this->updated;
    }

    public function setPublic(bool $public): self
    {
        $this->public = $public;

        return $this;
    }

    public function isPublic(): bool
    {
        return $this->public;
    }

    public function getPublished(): ?\DateTime
    {
        return $this->published;
    }

    public function setPublished(\DateTime $published)
    {
        $this->published = $published;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /** ---------- TAGS ---------- */
    public function addTag(Tags $tag): self
    {
        if ( ! $this->tags->contains($tag)) {
            $tag->addArticle($this);
            $this->tags[] = $tag;
        }

        return $this;
    }

    /**
     * Fonction to delete tag.
     */
    public function removeTag(Tags $tag): void
    {
        $this->tags->removeElement($tag);
        $tag->deleteArticle($this);
    }

    public function getTags(): iterable
    {
        return $this->tags;
    }

    public function setTags(iterable $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    /* -------------------- GESTION EVENEMENTS LIES ------------------------- */
    public function addEvenement(Evenement $evenement): self
    {
        if ( ! $this->evenements->contains($evenement)) {
            $evenement->addArticle($this);
            $this->evenements[] = $evenement;
        }

        return $this;
    }

    /**
     * Fonction to delete $evenement.
     */
    public function removeEvenement(Evenement $evenement): void
    {
        $this->evenements->removeElement($evenement);
        $evenement->removeArticle($this);
    }

    public function getEvenements(): iterable
    {
        return $this->evenements;
    }

    public function setEvenements(iterable $evenements): self
    {
        $this->evenements = $evenements;

        return $this;
    }

    public function __toString(): string
    {
        return $this->title ? $this->title : 'New Article';
    }

    public function getSlug(): string
    {
        $slug = (string) $this->id;
        if ($this->getUrl() && ! empty($this->getUrl()->getUrlKey())) {
            $slug = $this->getUrl()->getUrlKey();
        }

        return $slug;
    }
}
