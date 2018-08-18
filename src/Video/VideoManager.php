<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Video;

use App\Entity\Video;
use App\Repository\Video\YoutubeRepository;
use App\Repository\VideoRepository;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class VideoManager.
 */
class VideoManager
{
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ObjectManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function findAllVideosYoutube()
    {
        return $this->getVideoYoutubeeRepository()->findAll();
    }

    private function getVideoRepository(): VideoRepository
    {
        return $this->em->getRepository(Video::class);
    }

    private function getVideoYoutubeeRepository(): YoutubeRepository
    {
        return $this->em->getRepository(Video\Youtube::class);
    }
}
