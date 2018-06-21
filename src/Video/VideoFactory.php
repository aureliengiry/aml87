<?php

namespace App\Video;

use App\Entity\Video\Youtube;
use Google_Service_YouTube_PlaylistItem;

/**
 * Class VideoFactory.
 */
class VideoFactory
{
    /**
     * Create video with youtube data.
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
