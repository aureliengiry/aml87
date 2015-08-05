<?php
namespace Aml\Bundle\WebBundle\Twig;

use Twig_Extension;
use Twig_Filter_Method;
use Twig_Function_Method;

class PublicStatusExtension extends Twig_Extension
{
    public function getFilters()
    {
        return array
        (
            'publicStatus' => new Twig_Filter_Method($this, 'publicStatusFilter'),
        );
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