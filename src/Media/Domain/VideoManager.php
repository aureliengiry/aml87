<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Media\Domain;

use App\Media\Domain\Model\Video;
use App\Media\Infrastructure\Doctrine\Video\YoutubeDoctrineRepository;
use App\Media\Infrastructure\Doctrine\VideoDoctrineRepository;
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

    /**
     * VideoManager constructor.
     *
     * @param ObjectManager $entityManager
     */
    public function __construct(ObjectManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function findAllVideosYoutube()
    {
        return $this->getVideoYoutubeeRepository()->findAll();
    }

    private function getVideoRepository(): VideoDoctrineRepository
    {
        return $this->em->getRepository(Video::class);
    }

    private function getVideoYoutubeeRepository(): YoutubeDoctrineRepository
    {
        return $this->em->getRepository(Video\Youtube::class);
    }
}