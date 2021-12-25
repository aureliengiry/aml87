<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Entity;

use App\Utils\Slugger;
use Doctrine\ORM\Mapping as ORM;

/**
 * Url.
 *
 * @ORM\Table(name="core_url")
 * @ORM\Entity(repositoryClass="App\Repository\UrlRepository")
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="entity_source", type="string",length=50)
 * @ORM\DiscriminatorMap({
 *     "article" = "App\Entity\UrlArticle",
 *     "evenement" = "App\Entity\UrlEvenement",
 *     "discography" = "App\Entity\UrlDiscography",
 *     "page" = "App\Entity\UrlPage"
 * })
 */
abstract class Url
{
    /**
     * @ORM\Column(name="id_url", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected ?int $id;

    /**
     * @ORM\Column(name="url_key", type="string", length=255)
     */
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
