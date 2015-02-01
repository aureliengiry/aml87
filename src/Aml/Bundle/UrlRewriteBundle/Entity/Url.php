<?php

namespace Aml\Bundle\UrlRewriteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Url
 *
 * @ORM\Table(name="core_url")
 * @ORM\Entity(repositoryClass="Aml\Bundle\UrlRewriteBundle\Entity\Repository\UrlRepository")
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="entity_source", type="string",length=50)
 * @ORM\DiscriminatorMap({"article" = "UrlArticle", "evenement" = "UrlEvenement"})
 */
class Url
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
        $this->urlKey = $this->_build_SystemName($urlKey);

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

    /**
     * Format string to a valid URL
     *
     * @param $str
     * @param string $separator
     * @param bool $lowercase
     *
     * @return mixed|string
     */
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
}
