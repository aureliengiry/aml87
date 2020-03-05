<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Video;

use App\Entity\Video;
use App\Repository\Video\YoutubeRepository;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class VideoManager.
 */
class VideoManager
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findAllVideosYoutube()
    {
        return $this->getVideoYoutubeeRepository()->findAll();
    }

    private function getVideoRepository(): VideoRepository
    {
        return $this->entityManager->getRepository(Video::class);
    }

    private function getVideoYoutubeeRepository(): YoutubeRepository
    {
        return $this->entityManager->getRepository(Video\Youtube::class);
    }
}
