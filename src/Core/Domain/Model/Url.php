<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Core\Domain\Model;

use App\Core\Domain\Utils\Slugger;
use Doctrine\ORM\Mapping as ORM;

/**
 * Url.
 *
 * @ORM\Table(name="core_url")
 * @ORM\Entity(repositoryClass="App\Core\Infrastructure\Repository\UrlRepository")
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="entity_source", type="string",length=50)
 * @ORM\DiscriminatorMap({
 *     "article" = "App\Post\Domain\Model\UrlPost",
 *     "evenement" = "App\Agenda\Domain\Model\UrlEvenement",
 *     "discography" = "App\Discography\Domain\Model\UrlDiscography",
 *     "page" = "App\Page\Domain\Model\UrlPage"
 * })
 */
abstract class Url
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_url", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="url_key", type="string", length=255)
     */
    protected $urlKey;

    /**
     * Get id.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set urlKey.
     *
     * @param string $urlKey
     *
     * @return Url
     */
    public function setUrlKey($urlKey)
    {
        $slugger = new Slugger();
        $this->urlKey = $slugger->slugify($urlKey);

        return $this;
    }

    /**
     * Get urlKey.
     *
     * @return string
     */
    public function getUrlKey()
    {
        return $this->urlKey;
    }

    public function __toString()
    {
        return $this->urlKey ? $this->urlKey : 'Url not define';
    }
}
