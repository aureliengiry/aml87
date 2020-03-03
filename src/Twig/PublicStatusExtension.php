<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class PublicStatusExtension.
 */
class PublicStatusExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('publicStatus', [$this, 'publicStatusFilter']),
        ];
    }

    /**
     * réduit une chaine de caractères sans couper les mots.
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
}
