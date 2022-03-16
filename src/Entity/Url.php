<?php

declare(strict_types=1);

/**
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>.
 */

namespace App\Entity;

use App\Utils\Slugger;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'core_url')]
#[ORM\Entity(repositoryClass: \App\Repository\UrlRepository::class)]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'entity_source', type: 'string', length: 50)]
#[ORM\DiscriminatorMap(['article' => \App\Entity\UrlArticle::class, 'evenement' => \App\Entity\UrlEvenement::class, 'discography' => \App\Entity\UrlDiscography::class, 'page' => \App\Entity\UrlPage::class])]
abstract class Url implements \Stringable
{
    #[ORM\Column(name: 'id_url', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected ?int $id = null;

    #[ORM\Column(name: 'url_key', type: 'string', length: 255)]
    protected string $urlKey;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setUrlKey(string $urlKey): self
    {
        $slugger = new Slugger();
        $this->urlKey = $slugger->slugify($urlKey);

        return $this;
    }

    public function getUrlKey(): string
    {
        return $this->urlKey;
    }

    public function __toString(): string
    {
        return $this->urlKey ?: 'Url not define';
    }
}
