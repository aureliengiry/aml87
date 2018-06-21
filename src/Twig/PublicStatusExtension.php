<?php

namespace App\Twig;

use Twig_Extension;
use Twig_SimpleFilter;

/**
 * Class PublicStatusExtension.
 */
class PublicStatusExtension extends Twig_Extension
{
    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('publicStatus', [$this, 'publicStatusFilter']),
        ];
    }

    /**
     * réduit une chaine de caractères sans couper les mots.
     *
     * @param string $date     date à transformer
     * @param bool   $dateonly Affiche la date uniquement, quoiqu'il arrive
     * @param bool   $icon     afficher ou non l'icône avant la date
     * @param string $format   format dans lequel retourner la date si pas transformée
     *
     * @return string date plus nice à lire
     */
    public function publicStatusFilter($boolean)
    {
        if (true === $boolean) {
            return 'Publié';
        } else {
            return 'Brouillon';
        }
    }

    public function getName()
    {
        return 'publicStatus_extension';
    }
}
