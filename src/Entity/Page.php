<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * App\Entity\Page.
 *
 * @ORM\Table(name="webbundle_pages")
 *
 * @ORM\Entity(repositoryClass="App\Repository\PageRepository")
 */
class Page implements \Stringable
{
    /**
     * @var int
     */
    final public const PAGE_IS_PUBLIC = 1;

    /**
     * @var int
     */
    final public const PAGE_IS_PRIVATE = 0;

    /**
     * @ORM\Column(name="id", type="integer")
     *
     * @ORM\Id
     *
     * @ORM\GeneratedValue
     */
    private ?int $id = null;

    /**
     * @ORM\Column(name="title", type="string", length=255)
     */
    private string $title;

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
     * @ORM\Column(name="public", type="boolean")
     */
    private bool $public;

    /**
     * @var UrlPage url
     *
     * @ORM\OneToOne(targetEntity="\App\Entity\UrlPage", cascade={"all"})
     *
     * @ORM\JoinColumn(name="id_url", referencedColumnName="id_url")
     */
    private \App\Entity\UrlPage $url;

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
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set body.
     */
    public function setBody(string $body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body.
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * Set created.
     */
    public function setCreated(\DateTime $created = null)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created.
     */
    public function getCreated(): ?\DateTime
    {
        return $this->created;
    }

    /**
     * Set updated.
     */
    public function setUpdated(\DateTime $updated = null)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated.
     */
    public function getUpdated(): ?\DateTime
    {
        return $this->updated;
    }

    /**
     * Set public.
     */
    public function setPublic(bool $public)
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Get public.
     */
    public function isPublic(): ?bool
    {
        return $this->public;
    }

    /**
     * Set url.
     */
    public function setUrl(UrlPage $url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url.
     */
    public function getUrl(): ?UrlPage
    {
        return $this->url;
    }

    public function __toString(): string
    {
        return $this->title ?: 'New Page';
    }
}
