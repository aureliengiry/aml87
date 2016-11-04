<?php

namespace Aml\Bundle\UrlRewriteBundle\Entity;

use Aml\Bundle\UrlRewriteBundle\Utils\Slugger;

use Doctrine\ORM\Mapping as ORM;

/**
 * Url
 *
 * @ORM\Table(name="core_url")
 * @ORM\Entity(repositoryClass="Aml\Bundle\UrlRewriteBundle\Entity\Repository\UrlRepository")
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="entity_source", type="string",length=50)
 * @ORM\DiscriminatorMap({
 *     "article" = "Aml\Bundle\UrlRewriteBundle\Entity\UrlArticle",
 *     "evenement" = "Aml\Bundle\UrlRewriteBundle\Entity\UrlEvenement",
 *     "discography" = "Aml\Bundle\UrlRewriteBundle\Entity\UrlDiscography",
 *     "page" = "Aml\Bundle\UrlRewriteBundle\Entity\UrlPage"
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
