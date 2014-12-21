<?php

namespace Aml\Bundle\EvenementsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Aml\Bundle\EvenementsBundle\Entity\EvenementBlog;


/**
 * Aml\Bundle\EvenementsBundle\Entity\Evenement
 *
 * @ORM\Table(name="evenements")
 * @ORM\Entity(repositoryClass="Aml\Bundle\EvenementsBundle\Entity\Repository\EvenementRepository")
 */
class Evenement
{
    const EVENEMENT_TYPE_CONCERT = 'concert';
    const EVENEMENT_TYPE_REUNION = 'reunion';
    const EVENEMENT_TYPE_REPETITION = 'repetition';
    const EVENEMENT_TYPE_ENREGISTREMENT = 'enregistrement';
    const EVENEMENT_TYPE_CONCOURS = 'concours';
    const EVENEMENT_TYPE_SORTIE = 'sortie';

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id_evenement", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $type
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var datetime $dateStart
     *
     * @ORM\Column(name="date_start", type="datetime")
     */
    private $dateStart;

    /**
     * @var datetime $dateEnd
     *
     * @ORM\Column(name="date_end", type="datetime", nullable=true)
     */
    private $dateEnd;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var integer $picture
     *
     * @ORM\OneToOne(targetEntity="\Aml\Bundle\MediasBundle\Entity\Image", cascade={"all"})
     * @ORM\JoinColumn(name="id_media", referencedColumnName="id_media")
     */
    private $picture;

    /**
     * @var boolean $archive
     *
     * @ORM\Column(name="archive", type="boolean")
     */
    private $archive;

    /**
     * @var boolean $public
     *
     * @ORM\Column(name="public", type="boolean")
     */
    private $public;

    /**
     * @ORM\ManyToMany(targetEntity="\Aml\Bundle\BlogBundle\Entity\Article", inversedBy="evenements",cascade={"all"})
     * @ORM\JoinTable(name="evenements_articles",
     *        joinColumns={@ORM\JoinColumn(name="id_evenement", referencedColumnName="id_evenement")},
     *        inverseJoinColumns={@ORM\JoinColumn(name="id_article", referencedColumnName="id_article")}
     * )
     */
    protected $articles;

    /**
     * @ORM\ManyToMany(targetEntity="\Aml\Bundle\WebBundle\Entity\Partenaire", mappedBy="evenements", cascade={"all"})
     */
    protected $partenaires;

    /**
     * @var string url
     *
     * @ORM\Column(name="url", type="string", length=255, unique=true)
     */
    private $url;

    /**
     * @ORM\ManyToOne(targetEntity="Season", inversedBy="evenements")
     * @ORM\JoinColumn(name="id_season", referencedColumnName="id_season")
     */
    protected $season;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->partenaires = new ArrayCollection();
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
     * Set date
     *
     * @param datetime $dateStart
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;
        return $this;
    }

    /**
     * Get date
     *
     * @return datetime
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * Set dateEnd
     *
     * @param datetime $dateEnd
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;
        return $this;
    }

    /**
     * Get date
     *
     * @return datetime
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
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
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return text
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPicture()
    {
        return $this->picture;
    }


    /**
     * Set archive
     *
     * @param boolean $archive
     */
    public function setArchive($archive)
    {
        $this->archive = $archive;
        return $this;
    }

    /**
     * Get archive
     *
     * @return boolean
     */
    public function getArchive()
    {
        return $this->archive;
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
     * @return the $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Retourne le liste des différents types d'évènement
     * @return array
     */
    static function getTypesEvenements()
    {
        $typesEvenement = array();

        $typesEvenement[self::EVENEMENT_TYPE_CONCERT] = 'Concert';
        $typesEvenement[self::EVENEMENT_TYPE_CONCOURS] = 'Concours';
        $typesEvenement[self::EVENEMENT_TYPE_ENREGISTREMENT] = 'Enregistrement';
        $typesEvenement[self::EVENEMENT_TYPE_REPETITION] = 'Répétition';
        $typesEvenement[self::EVENEMENT_TYPE_REUNION] = 'Réunion';
        $typesEvenement[self::EVENEMENT_TYPE_SORTIE] = 'Sortie';

        return $typesEvenement;
    }

    /* ---------------- ARTICLES LIES ---------------- */
    public function getArticles()
    {
        return $this->articles;
    }

    public function setArticles($articles)
    {
        $this->articles = $articles;
        return $this;
    }

    public function addArticle($article)
    {
        $this->articles[] = $article;
    }

    /**
     * Fonction pour supprimer une discussion d'un mot clé
     * @param Discussion $discussion
     */
    public function removeArticle($article)
    {
        $this->articles->removeElement($article);
    }


    /* ---------------- PARTENAIRES ---------------- */
    /**
     *
     * @param Partenaire $partenaire
     */
    public function addPartenaire($partenaire)
    {
        $partenaire->addEvenement($this);
        $this->partenaires[] = $partenaire;
        return $this;
    }

    /**
     * Fonction to delete partenaire
     * @param Partenaire $partenaire
     */
    public function removePartenaire($partenaire)
    {
        $this->partenaires->removeElement($partenaire);
    }

    /**
     * @return Evenement
     */
    public function getPartenaires()
    {
        return $this->partenaires;
    }

    /**
     * @return Evenement
     */
    public function setPartenaires(ArrayCollection $partenaires)
    {
        $this->partenaires = $partenaires;
        return $this;
    }

    public function __toString()
    {
        return $this->title ?: 'New Event';
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

    protected function _build_SystemName($str, $separator = 'dash', $lowercase = TRUE)
    {
        if ($separator == 'dash') {
            $search = '_';
            $replace = '-';
        } else {
            $search = '-';
            $replace = '_';
        }

        $trans = array(
            '&\#\d+?;' => '',
            '&\S+?;' => '',
            '\s+' => $replace,
            '[^a-z0-9\-\._]' => '',
            $replace . '+' => $replace,
            $replace . '$' => $replace,
            '^' . $replace => $replace,
            '\.+$' => ''
        );

        $str = strip_tags($str);

        foreach ($trans as $key => $val) {
            $str = preg_replace("#" . $key . "#i", $val, $str);
        }

        if ($lowercase === TRUE) {
            $str = strtolower($str);
        }

        $str = trim(stripslashes($str));
        $str = str_replace(array('.'), array('-'), $str);

        return $str;
    }

    /**
     * @return mixed
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * @param mixed $category
     */
    public function setSeason($season)
    {
        $this->season = $season;
        return $this;
    }

    public function hasSeason(){
        return (bool)$this->season;
    }


}