<?php

namespace Aml\Bundle\WebBundle\Entity;

use Aml\Bundle\WebBundle\Utils\Slugger;

use Doctrine\ORM\Mapping as ORM;

/**
 * Url
 *
 * @ORM\Table(name="core_url")
 * @ORM\Entity(repositoryClass="Aml\Bundle\WebBundle\Repository\UrlRepository")
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="entity_source", type="string",length=50)
 * @ORM\DiscriminatorMap({
 *     "article" = "Aml\Bundle\WebBundle\Entity\UrlArticle",
 *     "evenement" = "Aml\Bundle\WebBundle\Entity\UrlEvenement",
 *     "discography" = "Aml\Bundle\WebBundle\Entity\UrlDiscography",
 *     "page" = "Aml\Bundle\WebBundle\Entity\UrlPage"
 * })
 */
abstract class Url
{
    /**
     * @var integer
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set urlKey
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
     * Get urlKey
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