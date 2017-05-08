<?php
namespace Tools\Bundle\YoutubeApiBundle\Api;

// Google API
use Google_Client;
use Google_Service_YouTube;

/**
 * Class Youtube
 * @package Tools\Bundle\YoutubeApiBundle\Api
 */
class Youtube
{
    const YOUTUBE_STATUS_PUBLIC = 'public';
    const YOUTUBE_STATUS_UNLISTED = 'unlisted';

    private $client;
    private $youtubeApi;
    private $googleAppName;
    private $googleDeveloperKey;

    /**
     * Constructor
     */
    public function __construct(string $googleAppName, string $googleDeveloperKey)
    {
        $this->googleAppName = $googleAppName;
        $this->googleDeveloperKey = $googleDeveloperKey;

        $this->initClient();
    }

    private function initClient()
    {
        $this->client = new Google_Client();
        $this->client->setApplicationName($this->googleAppName);
        $this->client->setDeveloperKey($this->googleDeveloperKey);

        $this->youtubeApi = new Google_Service_YouTube($this->client);
    }

    /**
     *
     */
    public function getYoutubeApi()
    {
        return $this->youtubeApi;
    }


}
