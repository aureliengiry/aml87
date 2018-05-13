<?php

namespace App\Video;

use App\Repository\Video\YoutubeRepository;
use App\Repository\VideoRepository;
use App\Entity\Video;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class VideoManager
 * @package App\Video
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
