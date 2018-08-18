<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Twig;

use Twig_Extension;
use Twig_SimpleFilter;

/**
 * Class SubstringExtension.
 */
class SubstringExtension extends Twig_Extension
{
    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('substring', [$this, 'substringFilter']),
        ];
    }

    /**
     * réduit une chaine de caractères sans couper les mots.
     *
     * @param string $longString chaine de caractères à réduire
     * @param int    $nbChar     nombre de caractères à afficher
     * @param string $endString  chaine de caractères terminant la chaine réduite (par défaut '[...]')
     *
     * @return string chaine réduite
     */
    public function substringFilter($longString, $nbChar = 10, $endString = '[...]')
    {
        $substring = $tmpString = '';
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

    public function getName()
    {
        return 'substring_extension';
    }
}
