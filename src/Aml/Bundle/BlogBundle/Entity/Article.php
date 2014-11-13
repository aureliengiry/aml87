<?php

namespace Aml\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Aml\Bundle\EvenementsBundle\Entity\EvenementBlog;

/**
 * Aml\Bundle\BlogBundle\Entity\Article
 *
 * @ORM\Table(name="blog_articles")
 * @ORM\Entity(repositoryClass="Aml\Bundle\BlogBundle\Entity\Repository\ArticleRepository")
 */
class Article
{
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
     * @ORM\Column(name="url", type="string", length=255,unique=true)
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

// 	/**
// 	 * @ORM\ManyToMany(targetEntity="File", mappedBy="articles", cascade={"persist"})
// 	 */
// 	protected $files;

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
        // $this->files = new ArrayCollection();
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
        $this->setUrl();
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
    public function setUrl()
    {
        $this->url = $this->_build_SystemName($this->title);
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
     * @return Partenaire
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
    public function getPublic()
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

// 	/**
// 	 *
// 	 * @param File $file
// 	 */
// 	public function addFiles($file) {
// 		$tag->addArticle($this);
// 		$this->files[] = $file;
// 		return $this;
// 	}

// 	/**
// 	 * @return the $files
// 	 */
// 	public function getFiles() {
// 		return $this->files;
// 	}


    protected function _build_SystemName($str, $separator = 'dash', $lowercase = TRUE)
    {
        if ($separator == 'dash')
        {
            $search     = '_';
            $replace    = '-';
        }
        else
        {
            $search     = '-';
            $replace    = '_';
        }

        $trans = array(
            '&\#\d+?;'              => '',
            '&\S+?;'                => '',
            '\s+'                   => $replace,
            '[^a-z0-9\-\._]'        => '',
            $replace.'+'            => $replace,
            $replace.'$'            => $replace,
            '^'.$replace            => $replace,
            '\.+$'                  => ''
        );

        $str = strip_tags($str);

        foreach ($trans as $key => $val)
        {
            $str = preg_replace("#".$key."#i", $val, $str);
        }

        if ($lowercase === TRUE)
        {
            $str = strtolower($str);
        }

        $str = trim(stripslashes($str));
        $str = str_replace(array('.'), array('-'), $str);

        return $str;
    }

    /** ---------- TAGS ---------- */
    /**
     *
     * @param TumblrTag $tag
     */
    public function addTag($tag)
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
    public function removeTag($tag)
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
     *
     * @param TumblrTag $tag
     */
    public function addEvenement($evenement)
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
    public function removeEvenement($evenement)
    {
        $this->evenements->removeElement($evenement);
        $evenement->deleteArticle($this);
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
        return $this->title ? : 'New Article';
    }
}