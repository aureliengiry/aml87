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
    /**
     * Create video with youtube data
     *
     * @param Google_Service_YouTube_PlaylistItem $youtubeData
     *
     * @return Youtube
     */
    public function createVideoFromYoutube(Google_Service_YouTube_PlaylistItem $youtubeData): Youtube
    {
        return new Youtube(
            $youtubeData->getSnippet()->getTitle(),
            $youtubeData->getContentDetails()->getVideoId()
        );
    }
}
