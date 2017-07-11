<?php

namespace Aml\Bundle\DiscographyBundle\Discography;

use Aml\Bundle\DiscographyBundle\Entity\Album;
use Doctrine\ORM\EntityManager;

/**
 * Class DiscographyManager
 * @package Aml\Bundle\DiscographyBundle\Discography
 */
class DiscographyManager
{
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;

    }

    public function getPublicAlbums()
    {
        return $this->getAlbumRepository()->findBy(
            ['public' => "1"],
            ['date' => 'DESC']
        );
    }

    private function getAlbumRepository()
    {
        return $this->em->getRepository(Album::class);
    }
}
