<?php

namespace Aml\Bundle\WebBundle\Twig;

use Twig_Extension;
use Twig_SimpleFilter;

/**
 * Class WordWarpExtension
 * @package Aml\Bundle\WebBundle\Twig
 */
class WordWarpExtension extends Twig_Extension
{
    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('wordWarp', [$this, 'wordWarpFilter'], ['is_safe' => ['html']]),
            new Twig_SimpleFilter('isWordWarp', [$this, 'isWordWarpFilter']),
        ];
    }

    /**
     * réduit une chaine de caractères sans couper les mots
     *
     * @param string $date date à transformer
     * @param boolean $dateonly Affiche la date uniquement, quoiqu'il arrive
     * @param boolean $icon afficher ou non l'icône avant la date
     * @param string $format format dans lequel retourner la date si pas transformée
     *
     * @return string date plus nice à lire
     */
    public function wordWarpFilter($str, $length = 500, $id = null, $wordwarp = true)
    {
        // Delete HTML tags
        $str = $this->stripHtmlTags($str);

        // Delete \n \r \t
        $str = str_replace(["\r\n", "\n", "\r", "\t"], '', $str);

        if (strlen($str) > $length) {
            if ($wordwarp) {
                $length = $this->findSpace($str, $length);
            }
            $text = '<div class="expand">' . mb_substr($str, 0, $length) . ' ...</div>';

            return $text;
        } else {
            return $str;
        }
    }

    /**
     * réduit une chaine de caractères sans couper les mots
     *
     * @param string $date date à transformer
     * @param boolean $dateonly Affiche la date uniquement, quoiqu'il arrive
     * @param boolean $icon afficher ou non l'icône avant la date
     * @param string $format format dans lequel retourner la date si pas transformée
     *
     * @return string date plus nice à lire
     */
    public function isWordWarpFilter($str, $length = 200)
    {
        $str = $this->stripHtmlTags($str);
        if (strlen($str) > $length) {
            return true;
        }

        return false;
    }

    /**
     * Remove HTML tags, including invisible text such as style and
     * script code, and embedded objects.  Add line breaks around
     * block-level tags to prevent word joining after tag removal.
     */
    public function stripHtmlTags($text)
    {
        $allowedTags = '<strong><em>';

        return strip_tags($text, $allowedTags);
    }

    public function getName()
    {
        return 'wordWarp_extension';
    }

    public function findSpace($str, $length)
    {
        while ($length > 0 && !$val = mb_strpos($str, ' ', $length)) {
            $length = $length - 10;
        }

        return $val;
    }
}
