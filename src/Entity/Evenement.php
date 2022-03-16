<?php

declare(strict_types=1);

/**
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'evenements')]
#[ORM\Entity(repositoryClass: \App\Repository\EvenementRepository::class)]
class Evenement implements \Stringable
{
    final public const EVENEMENT_TYPE_CONCERT = 'concert';
    final public const EVENEMENT_TYPE_REUNION = 'reunion';
    final public const EVENEMENT_TYPE_REPETITION = 'repetition';
    final public const EVENEMENT_TYPE_ENREGISTREMENT = 'enregistrement';
    final public const EVENEMENT_TYPE_CONCOURS = 'concours';
    final public const EVENEMENT_TYPE_SORTIE = 'sortie';

    #[ORM\Column(name: 'id_evenement', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private ?int $id = null;

    #[ORM\Column(name: 'type', type: 'string', length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(name: 'date_start', type: 'datetime')]
    private \DateTime $dateStart;

    #[ORM\Column(name: 'date_end', type: 'datetime', nullable: true)]
    private ?\DateTime $dateEnd = null;

    #[ORM\Column(name: 'title', type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(name: 'description', type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\OneToOne(targetEntity: \App\Entity\Image::class, cascade: ['all'])]
    #[ORM\JoinColumn(name: 'id_media', referencedColumnName: 'id_media')]
    private ?Image $picture = null;

    #[ORM\Column(name: 'archive', type: 'boolean')]
    private bool $archive = false;

    #[ORM\Column(name: 'public', type: 'boolean')]
    private bool $public = false;

    #[ORM\ManyToMany(targetEntity: \App\Entity\Article::class, inversedBy: 'evenements', cascade: ['all'], fetch: 'LAZY')]
    #[ORM\JoinTable(name: 'evenements_articles', joinColumns: [new ORM\JoinColumn(name: 'id_evenement', referencedColumnName: 'id_evenement')], inverseJoinColumns: [new ORM\JoinColumn(name: 'id_article', referencedColumnName: 'id_article')])]
    protected Collection $articles;

    #[ORM\ManyToMany(targetEntity: \App\Entity\Partenaire::class, mappedBy: 'evenements', cascade: ['all'], fetch: 'LAZY')]
    protected Collection $partenaires;

    #[ORM\OneToOne(targetEntity: \App\Entity\Url::class, cascade: ['all'], fetch: 'EAGER')]
    #[ORM\JoinColumn(name: 'id_url', referencedColumnName: 'id_url')]
    private Url $url;

    #[ORM\ManyToOne(targetEntity: 'Season', inversedBy: 'evenements')]
    #[ORM\JoinColumn(name: 'id_season', referencedColumnName: 'id_season')]
    protected Season $season;

    #[ORM\ManyToMany(targetEntity: \App\Entity\Video\Youtube::class, inversedBy: 'evenements', cascade: ['all'], fetch: 'LAZY')]
    #[ORM\JoinTable(name: 'evenements_videos', joinColumns: [new ORM\JoinColumn(name: 'id_evenement', referencedColumnName: 'id_evenement')], inverseJoinColumns: [new ORM\JoinColumn(name: 'id_video', referencedColumnName: 'id_video')])]
    protected Collection $videos;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->partenaires = new ArrayCollection();
        $this->videos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setDateStart(\DateTime $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateStart(): \DateTime
    {
        return $this->dateStart;
    }

    public function setDateEnd(?\DateTime $dateEnd = null): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getDateEnd(): ?\DateTime
    {
        return $this->dateEnd;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setPicture(Image $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getPicture(): ?Image
    {
        return $this->picture;
    }

    public function setArchive(bool $archive): self
    {
        $this->archive = $archive;

        return $this;
    }

    public function isArchive(): bool
    {
        return $this->archive;
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

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public static function getTypesEvenements(): array
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
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function setArticles(Collection $articles): self
    {
        $this->articles = $articles;

        return $this;
    }

    public function addArticle(Article $article): void
    {
        $this->articles[] = $article;
    }

    public function removeArticle(Article $article): void
    {
        $this->articles->removeElement($article);
    }

    /* ---------------- PARTENAIRES ---------------- */
    public function addPartenaire(Partenaire $partenaire): self
    {
        $partenaire->addEvenement($this);
        $this->partenaires[] = $partenaire;

        return $this;
    }

    public function removePartenaire(Partenaire $partenaire): void
    {
        $this->partenaires->removeElement($partenaire);
    }

    public function getPartenaires(): Collection
    {
        return $this->partenaires;
    }

    public function setPartenaires(Collection $partenaires): self
    {
        $this->partenaires = $partenaires;

        return $this;
    }

    /* ---------------- VIDEOS LIEES ---------------- */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function setVideos(Collection $videos): self
    {
        $this->videos = $videos;

        return $this;
    }

    public function addVideo(Video $video): void
    {
        $this->videos[] = $video;
    }

    public function removeVideo(Video $video): void
    {
        $this->videos->removeElement($video);
    }

    public function __toString(): string
    {
        return $this->title ?: 'New Event';
    }

    public function setUrl(Url $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }

    public function getSeason(): Season
    {
        return $this->season;
    }

    public function setSeason(Season $season): self
    {
        $this->season = $season;

        return $this;
    }

    public function hasSeason(): bool
    {
        return (bool) $this->season;
    }

    public function getSlug(): string
    {
        $slug = (string) $this->id;
        if ($this->getUrl() && ! empty($this->getUrl()->getUrlKey())) {
            $slug = $this->getUrl()->getUrlKey();
        }

        return $slug;
    }

    public function getDates(): string
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
