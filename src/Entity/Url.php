<?php

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
     *
     * @return int
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
