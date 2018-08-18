<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

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
     *
     * @return string date plus nice à lire
     */
    public function publicStatusFilter($boolean)
    {
        if (true === $boolean) {
            return 'Publié';
        }

        return 'Brouillon';
    }

    public function getName()
    {
        return 'publicStatus_extension';
    }
}
