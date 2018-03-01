<?php

namespace App\Video;

use App\Entity\Repository\Video\YoutubeRepository;
use App\Entity\Repository\VideoRepository;
use App\Entity\Video;
use Doctrine\ORM\EntityManager;

/**
 * Class VideoManager
 * @package App\Video
 */
class VideoManager
{
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function findAllVideosYoutube(){
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
