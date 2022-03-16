<?php

declare(strict_types=1);

/**
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>.
 */

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
     */
    public function createVideoFromYoutube(Google_Service_YouTube_PlaylistItem $youtubeData): Youtube
    {
        return new Youtube(
            $youtubeData->getSnippet()->getTitle(),
            $youtubeData->getContentDetails()->getVideoId()
        );
    }
}
