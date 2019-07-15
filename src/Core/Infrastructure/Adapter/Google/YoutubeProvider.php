<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Core\Infrastructure\Adapter\Google;

use Google_Service_YouTube;

/**
 * Class YoutubeProvider.
 */
class YoutubeProvider
{
    /** @var Client */
    private $googleClient;
    private $youtubeUsername;

    private $youtubeService;

    /**
     * YoutubeProvider constructor.
     *
     * @param Client $googleClient
     * @param string $youtubeUsername
     */
    public function __construct(Client $googleClient, string $youtubeUsername)
    {
        $this->googleClient = $googleClient;
        $this->youtubeUsername = $youtubeUsername;
    }

    public function init() : void
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
     * @param string $playlistId
     * @param int $maxResults
     *
     * @return mixed
     */
    public function getVideosPlaylist(string $playlistId, int $maxResults = 50)
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
