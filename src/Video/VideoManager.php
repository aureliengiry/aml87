<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Video;

use App\Entity\Video;
use App\Repository\Video\YoutubeRepository;
use Doctrine\ORM\EntityManagerInterface;

class VideoManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findAllVideosYoutube(): iterable
    {
        return $this->getVideoYoutubeRepository()->findAll();
    }

    private function getVideoYoutubeRepository(): YoutubeRepository
    {
        return $this->entityManager->getRepository(Video\Youtube::class);
    }
}
