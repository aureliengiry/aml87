<?php

namespace Aml\Bundle\MediasBundle\Video;

use Aml\Bundle\MediasBundle\Entity\Repository\Video\YoutubeRepository;
use Aml\Bundle\MediasBundle\Entity\Repository\VideoRepository;
use Aml\Bundle\MediasBundle\Entity\Video;
use Doctrine\ORM\EntityManager;

/**
 * Class VideoManager
 * @package Aml\Bundle\MediasBundle\Video
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
