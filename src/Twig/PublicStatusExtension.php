<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PublicStatusExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('publicStatus', $this->publicStatusFilter(...)),
        ];
    }

    /**
     * Réduit une chaine de caractères sans couper les mots.
     */
    public function publicStatusFilter(bool $boolean): string
    {
        if ($boolean) {
            return 'Publié';
        }

        return 'Brouillon';
    }
}
