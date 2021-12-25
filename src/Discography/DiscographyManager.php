<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Discography;

use App\Entity\Album;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class DiscographyManager.
 */
class DiscographyManager
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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
        return $this->entityManager->getRepository(Album::class);
    }
}
