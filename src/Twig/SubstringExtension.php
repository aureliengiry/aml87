<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class SubstringExtension.
 */
class SubstringExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('substring', $this->substringFilter(...)),
        ];
    }

    /**
     * réduit une chaine de caractères sans couper les mots.
     *
     * @param string      $longString chaine de caractères à réduire
     * @param int|null    $nbChar     nombre de caractères à afficher
     * @param string|null $endString  chaine de caractères terminant la chaine réduite (par défaut '[...]')
     *
     * @return string chaine réduite
     */
    public function substringFilter(string $longString, ?int $nbChar = 10, ?string $endString = '[...]'): string
    {
        $substring = '';
        $tmpString = '';
        $tmpArray = [];
        if (mb_strlen($longString) > $nbChar) {
            $tmpString = wordwrap($longString, $nbChar, '#@@#', false);
            $tmpArray = explode('#@@#', $tmpString);
            $substring = $tmpArray[0].' '.$endString;
        } else {
            $substring = $longString;
        }

        return $substring;
    }
}
