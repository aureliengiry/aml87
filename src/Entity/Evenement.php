<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * App\Entity\Evenement.
 *
 * @ORM\Table(name="evenements")
 * @ORM\Entity(repositoryClass="App\Repository\EvenementRepository")
 */
class Evenement
{
    public const EVENEMENT_TYPE_CONCERT = 'concert';
    public const EVENEMENT_TYPE_REUNION = 'reunion';
    public const EVENEMENT_TYPE_REPETITION = 'repetition';
    public const EVENEMENT_TYPE_ENREGISTREMENT = 'enregistrement';
    public const EVENEMENT_TYPE_CONCOURS = 'concours';
    public const EVENEMENT_TYPE_SORTIE = 'sortie';

    /**
     * @var int
     *
     * @ORM\Column(name="id_evenement", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private ?int $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_start", type="datetime")
     */
    private $dateStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_end", type="datetime", nullable=true)
     */
    private $dateEnd;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\OneToOne(targetEntity="\App\Entity\Image", cascade={"all"})
     * @ORM\JoinColumn(name="id_media", referencedColumnName="id_media")
     */
    private $picture;

    /**
     * @var bool
     *
     * @ORM\Column(name="archive", type="boolean")
     */
    private $archive;

    /**
     * @var bool
     *
     * @ORM\Column(name="public", type="boolean")
     */
    private $public = false;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Article", inversedBy="evenements",cascade={"all"}, fetch="LAZY")
     * @ORM\JoinTable(name="evenements_articles",
     *        joinColumns={@ORM\JoinColumn(name="id_evenement", referencedColumnName="id_evenement")},
     *        inverseJoinColumns={@ORM\JoinColumn(name="id_article", referencedColumnName="id_article")}
     * )
     */
    protected $articles;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Partenaire", mappedBy="evenements", cascade={"all"}, fetch="LAZY")
     */
    protected $partenaires;

    /**
     * @var string url
     *
     * @ORM\OneToOne(targetEntity="\App\Entity\Url", cascade={"all"}, fetch="EAGER")
     * @ORM\JoinColumn(name="id_url", referencedColumnName="id_url")
     */
    private $url;

    /**
     * @ORM\ManyToOne(targetEntity="Season", inversedBy="evenements")
     * @ORM\JoinColumn(name="id_season", referencedColumnName="id_season")
     */
    protected $season;

    /**
     * @ORM\ManyToMany(targetEntity="\App\Entity\Video\Youtube", inversedBy="evenements", cascade={"all"}, fetch="LAZY")
     * @ORM\JoinTable(name="evenements_videos",
     *        joinColumns={@ORM\JoinColumn(name="id_evenement", referencedColumnName="id_evenement")},
     *        inverseJoinColumns={@ORM\JoinColumn(name="id_video", referencedColumnName="id_video")}
     * )
     */
    protected $videos;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->partenaires = new ArrayCollection();
        $this->videos = new ArrayCollection();
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
     * Set date.
     */
    public function setDateStart(\DateTime $dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get date.
     */
    public function getDateStart(): ?\DateTime
    {
        return $this->dateStart;
    }

    /**
     * Set dateEnd.
     */
    public function setDateEnd(\DateTime $dateEnd = null)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get date.
     */
    public function getDateEnd(): ?\DateTime
    {
        return $this->dateEnd;
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
     * Set description.
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set archive.
     */
    public function setArchive(bool $archive)
    {
        $this->archive = $archive;

        return $this;
    }

    /**
     * Is archive.
     *
     * @return bool
     */
    public function isArchive(): ?bool
    {
        return $this->archive;
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
    public function isPublic(): bool
    {
        return $this->public;
    }

    /**
     * @return string $type
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
     * Retourne le liste des différents types d'évènement.
     *
     * @return array
     */
    public static function getTypesEvenements()
    {
        $typesEvenement = [];

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

    public function setArticles(ArrayCollection $articles)
    {
        $this->articles = $articles;

        return $this;
    }

    public function addArticle(Article $article)
    {
        $this->articles[] = $article;
    }

    /**
     * Fonction pour supprimer une discussion d'un mot clé.
     */
    public function removeArticle(Article $article)
    {
        $this->articles->removeElement($article);
    }

    /* ---------------- PARTENAIRES ---------------- */

    public function addPartenaire(Partenaire $partenaire)
    {
        $partenaire->addEvenement($this);
        $this->partenaires[] = $partenaire;

        return $this;
    }

    /**
     * Fonction to delete partenaire.
     */
    public function removePartenaire(Partenaire $partenaire)
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

    /* ---------------- VIDEOS LIEES ---------------- */
    public function getVideos()
    {
        return $this->videos;
    }

    public function setVideos(ArrayCollection $videos)
    {
        $this->videos = $videos;

        return $this;
    }

    public function addVideo(Video $video)
    {
        $this->videos[] = $video;
    }

    /**
     * Remove Video.
     */
    public function removeVideo(Video $video)
    {
        $this->videos->removeElement($video);
    }

    public function __toString()
    {
        return $this->title ?: 'New Event';
    }

    /**
     * Set title.
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    public function getSeason()
    {
        return $this->season;
    }

    public function setSeason($season)
    {
        $this->season = $season;

        return $this;
    }

    public function hasSeason()
    {
        return (bool) $this->season;
    }

    public function getSlug()
    {
        $slug = $this->id;
        if ($this->getUrl() && ! empty($this->getUrl()->getUrlKey())) {
            $slug = $this->getUrl()->getUrlKey();
        }

        return $slug;
    }

    public function getDates()
    {
        if (null === $this->dateEnd) {
            return $this->dateStart->format('d M Y à H:m');
        }

        $formatedDateStart = $this->dateStart->format('d M Y');
        $formatedDateEnd = $this->dateEnd->format('d M Y');

        if ($formatedDateStart === $formatedDateEnd) {
            return sprintf(
                'Le %s de %s à %s',
                $this->dateStart->format('d M Y'),
                $this->dateStart->format('H:m'),
                $this->dateEnd->format('H:m')
            );
        }

        return sprintf(
            'Du %s au %s',
            $this->dateStart->format('d M Y à H:m'),
            $this->dateEnd->format('d M Y à H:m')
        );
    }

    public function isConcert(): bool
    {
        return self::EVENEMENT_TYPE_CONCERT === $this->type;
    }
}
