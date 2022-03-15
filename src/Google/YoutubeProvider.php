<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Google;

use Google_Service_YouTube;

/**
 * Class YoutubeProvider.
 */
class YoutubeProvider
{
    private ?Google_Service_YouTube $youtubeService = null;

    /**
     * YoutubeProvider constructor.
     */
    public function __construct(private readonly Client $googleClient, private readonly string $youtubeUsername)
    {
    }

    public function init(): void
    {
        $this->youtubeService = new Google_Service_YouTube($this->googleClient->get());
    }

    public function getPlaylists()
    {
        $this->init();

        return $this->youtubeService->channels->listChannels(
            'contentDetails',
            ['forUsername' => $this->youtubeUsername]
        );
    }

    public function getPlaylistUploadId()
    {
        foreach ($this->getPlaylists()->getItems() as $item) {
            return $item['contentDetails']['relatedPlaylists']['uploads'];
        }
    }

    /**
     * Load youtube videos of playlist.
     *
     * @param int $maxResults
     */
    public function getVideosPlaylist(string $playlistId, $maxResults = 50)
    {
        return $this->youtubeService->playlistItems->listPlaylistItems(
            'snippet,contentDetails',
            [
                'playlistId' => $playlistId,
                'maxResults' => $maxResults,
            ]
        );
    }
}
