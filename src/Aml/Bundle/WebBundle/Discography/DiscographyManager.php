<?php

namespace Aml\Bundle\WebBundle\Discography;

use Aml\Bundle\WebBundle\Entity\Album;
use Doctrine\ORM\EntityManager;

/**
 * Class DiscographyManager
 * @package Aml\Bundle\WebBundle\Discography
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
