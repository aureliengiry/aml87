<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * App\Entity\Page.
 *
 * @ORM\Table(name="pages")
 * @ORM\Entity(repositoryClass="App\Repository\PageRepository")
 */
class Page
{
    const PAGE_IS_PUBLIC = 1;
    const PAGE_IS_PRIVATE = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text")
     */
    private $body;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

    /**
     * @var bool
     *
     * @ORM\Column(name="public", type="boolean")
     */
    private $public;

    /**
     * @var UrlPage url
     *
     * @ORM\OneToOne(targetEntity="\App\Entity\UrlPage", cascade={"all"})
     * @ORM\JoinColumn(name="id_url", referencedColumnName="id_url")
     */
    private $url;

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
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
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
     *
     * @return string
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
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
     *
     * @param \DateTime $updated
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
     *
     * @return bool
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

    public function __toString()
    {
        return $this->title ?: 'New Page';
    }
}
