<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Evenement;

/**
 * App\Entity\Article
 *
 * @ORM\Table(name="blog_articles")
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
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
     * @var UrlArticle url
     *
     * @ORM\OneToOne(targetEntity="\App\Entity\UrlArticle", cascade={"all"}, fetch="EAGER")s
     * @ORM\JoinColumn(name="id_url", referencedColumnName="id_url")
     */
    private $url;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Image", cascade={"all"})
     * @ORM\JoinColumn(name="id_media", referencedColumnName="id_media")
     */
    private $logo;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Video\Youtube", cascade={"all"})
     * @ORM\JoinColumn(name="id_video", referencedColumnName="id_video")
     */
    private $video;

    /**
     * @var string $body
     *
     * @ORM\Column(name="body", type="text")
     */
    private $body;

    /**
     * @var \DateTime $created
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
     * @var \DateTime $published
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
     * @ORM\ManyToMany(targetEntity="\App\Entity\Evenement", mappedBy="articles", cascade={"all"})
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
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * Set title
     *
     * @param UrlArticle $url
     */
    public function setUrl(UrlArticle $url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return UrlArticle
     */
    public function getUrl() : UrlArticle
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
     * Is public
     *
     * @return boolean
     */
    public function isPublic() : bool
    {
        return $this->public;
    }

    /**
     * @return \DateTime $published
     */
    public function getPublished() : \DateTime
    {
        return $this->published;
    }

    /**
     * @param \DateTime $published
     */
    public function setPublished(\DateTime $published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * @return Category $id_blog_category
     */
    public function getCategory() : Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /** ---------- TAGS ---------- */
    /**
     *
     * @param Tags $tag
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
     *
     * @param Tags $tag
     */
    public function removeTag(Tags $tag)
    {
        $this->tags->removeElement($tag);
        $tag->deleteArticle($this);
    }

    /**
     * @return ArrayCollection $tags
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return Article
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
     * @return ArrayCollection $evenements
     */
    public function getEvenements()
    {
        return $this->evenements;
    }

    /**
     * @return ArrayCollection $evenements
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
