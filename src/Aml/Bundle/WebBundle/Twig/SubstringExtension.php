<?php

namespace Aml\Bundle\WebBundle\Twig;

use Twig_Extension;
use Twig_SimpleFilter;

/**
 * Class SubstringExtension
 * @package Aml\Bundle\WebBundle\Twig
 */
class SubstringExtension extends Twig_Extension
{

    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('substring', [$this, 'substringFilter'])
        );
    }

    /**
     * réduit une chaine de caractères sans couper les mots
     *
     * @param string $longString chaine de caractères à réduire
     * @param integer $nbChar nombre de caractères à afficher
     * @param string $endString chaine de caractères terminant la chaine réduite (par défaut '[...]')
     *
     * @return string chaine réduite
     */
    public function substringFilter($longString, $nbChar = 10, $endString = '[...]')
    {

        $substring = $tmpString = '';
        $tmpArray = [];
        if (strlen($longString) > $nbChar) {
            $tmpString = wordwrap($longString, $nbChar, '#@@#', false);
            $tmpArray = explode('#@@#', $tmpString);
            $substring = $tmpArray[0] . ' ' . $endString;
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
