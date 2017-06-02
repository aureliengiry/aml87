<?php

namespace Aml\Bundle\MediasBundle\Video;

use Aml\Bundle\MediasBundle\Entity\Video\Youtube;
use Google_Service_YouTube_PlaylistItem;
/**
 * Class VideoFactory
 * @package Aml\Bundle\MediasBundle\Video
 */
class VideoFactory
{
    public function createVideoFromYoutube(Google_Service_YouTube_PlaylistItem $youtubeData): Youtube
    {
        //$video = new Youtube();
//                    $video
//                        ->setTitle($snippet->getTitle())
//                        ->setProviderId($idYoutube);
        return new Youtube(
            $youtubeData->getSnippet()->getTitle(),
            $youtubeData->getContentDetails()->getVideoId()
        );
    }
}