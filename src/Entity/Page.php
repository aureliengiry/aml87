<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * App\Entity\Page
 *
 * @ORM\Table(name="webbundle_pages")
 * @ORM\Entity(repositoryClass="App\Repository\PageRepository")
 */
class Page
{
    const PAGE_IS_PUBLIC = 1;
    const PAGE_IS_PRIVATE = 0;

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string $body
     *
     * @ORM\Column(name="body", type="text")
     */
    private $body;

    /**
     * @var \\DateTime $created
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

    /**
     * @var boolean $public
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
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set body
     *
     * @param string $body
     */
    public function setBody(string $body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody() : string
    {
        return $this->body;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created = null)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated() : \DateTime
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     */
    public function setUpdated(\DateTime $updated = null)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated() : \DateTime
    {
        return $this->updated;
    }

    /**
     * Set public
     *
     * @param boolean $public
     */
    public function setPublic(bool $public)
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Get public
     *
     * @return boolean
     */
    public function isPublic() : bool
    {
        return $this->public;
    }

    /**
     * Set url
     *
     * @param UrlPage $url
     */
    public function setUrl(UrlPage $url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return UrlPage
     */
    public function getUrl() : UrlPage
    {
        return $this->url;
    }

    public function __toString()
    {
        return $this->title ?: 'New Page';
    }
}
