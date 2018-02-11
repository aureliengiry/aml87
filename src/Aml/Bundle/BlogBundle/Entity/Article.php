<?php

namespace Aml\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Aml\Bundle\EvenementsBundle\Entity\Evenement;

/**
 * Aml\Bundle\BlogBundle\Entity\Article
 *
 * @ORM\Table(name="blog_articles")
 * @ORM\Entity(repositoryClass="Aml\Bundle\BlogBundle\Repository\ArticleRepository")
 */
class Article
{
    const ARTICLE_IS_PUBLIC = 1;
    const ARTICLE_IS_PRIVATE = 0;

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id_article", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title = '';

    /**
     * @var string url
     *
     * @ORM\OneToOne(targetEntity="\Aml\Bundle\UrlRewriteBundle\Entity\Url", cascade={"all"}, fetch="EAGER")s
     * @ORM\JoinColumn(name="id_url", referencedColumnName="id_url")
     */
    private $url;

    /**
     * @ORM\OneToOne(targetEntity="\Aml\Bundle\MediasBundle\Entity\Image", cascade={"all"})
     * @ORM\JoinColumn(name="id_media", referencedColumnName="id_media")
     */
    private $logo;

    /**
     * @ORM\OneToOne(targetEntity="\Aml\Bundle\MediasBundle\Entity\Video\Youtube", cascade={"all"})
     * @ORM\JoinColumn(name="id_video", referencedColumnName="id_video")
     */
    private $video;

    /**
     * @var text $body
     *
     * @ORM\Column(name="body", type="text")
     */
    private $body;

    /**
     * @var datetime $created
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var datetime $updated
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

    /**
     * @var datetime $published
     *
     * @ORM\Column(name="published", type="datetime",nullable=true)
     */
    private $published;

    /**
     * @var boolean $public
     *
     * @ORM\Column(name="public", type="boolean")
     */
    private $public;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="articles")
     * @ORM\JoinColumn(name="id_category", referencedColumnName="id_category")
     */
    protected $category;

    /**
     * @ORM\ManyToMany(targetEntity="Tags", mappedBy="articles", cascade={"all"})
     */
    protected $tags;

    /**
     * @ORM\ManyToMany(targetEntity="\Aml\Bundle\EvenementsBundle\Entity\Evenement", mappedBy="articles", cascade={"all"})
     */
    protected $evenements;

    public function __construct()
    {
        $this->evenements = new ArrayCollection();

        $this->tags = new ArrayCollection();
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
     * Set title
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set logo
     *
     * @param string $logo
     *
     * @return Article
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param mixed $video
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set body
     *
     * @param text $body
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return text
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set created
     *
     * @param datetime $created
     */
    public function setCreated(\DateTime $created = null)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return datetime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param datetime $updated
     */
    public function setUpdated(\DateTime $updated = null)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return datetime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set public
     *
     * @param boolean $public
     */
    public function setPublic($public)
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Get public
     *
     * @return boolean
     */
    public function isPublic()
    {
        return $this->public;
    }

    /**
     * @return the $published
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * @param datetime $published
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * @return the $id_blog_category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param field_type $id_blog_category
     */
    public function setCategory($id_blog_category)
    {
        $this->category = $id_blog_category;

        return $this;
    }

    /** ---------- TAGS ---------- */
    /**
     *
     * @param TumblrTag $tag
     */
    public function addTag(Tags $tag)
    {
        if (!$this->tags->contains($tag)) {
            $tag->addArticle($this);
            $this->tags[] = $tag;
        }

        return $this;
    }

    /**
     * Fonction to delete tag
     * @param Discussion $discussion
     */
    public function removeTag(Tags $tag)
    {
        $this->tags->removeElement($tag);
        $tag->deleteArticle($this);
    }

    /**
     * @return the $tags
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return the $tags
     */
    public function setTags(ArrayCollection $tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /* -------------------- GESTION EVENEMENTS LIES ------------------------- */
    /**
     * @param Evenement $evenement
     * @return $this
     */
    public function addEvenement(Evenement $evenement)
    {
        if (!$this->evenements->contains($evenement)) {
            $evenement->addArticle($this);
            $this->evenements[] = $evenement;
        }

        return $this;
    }

    /**
     * Fonction to delete $evenement
     * @param Evenement $evenement
     */
    public function removeEvenement(Evenement $evenement)
    {
        $this->evenements->removeElement($evenement);
        $evenement->removeArticle($this);
    }

    /**
     * @return the $evenements
     */
    public function getEvenements()
    {
        return $this->evenements;
    }

    /**
     * @return the $evenements
     */
    public function setEvenements(ArrayCollection $evenements)
    {
        $this->evenements = $evenements;

        return $this;
    }

    public function __toString()
    {
        return $this->title ? $this->title : 'New Article';
    }

    public function getSlug()
    {
        $slug = $this->id;
        if ($this->getUrl() && !empty($this->getUrl()->getUrlKey())) {
            $slug = $this->getUrl()->getUrlKey();
        }

        return $slug;
    }
}
