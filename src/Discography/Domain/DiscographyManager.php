<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Discography\Domain;

use App\Discography\Domain\Model\Album;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class DiscographyManager.
 */
class DiscographyManager
{
    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * DiscographyManager constructor.
     */
    public function __construct(ObjectManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getPublicAlbums()
    {
        return $this->getAlbumRepository()->findBy(
            ['public' => '1'],
            ['date' => 'DESC']
        );
    }

    private function getAlbumRepository()
    {
        return $this->em->getRepository(Album::class);
    }
}
