<?php

namespace Aml\Bundle\WebBundle\Google;

use Monolog\Logger;
use Google_Client;

/**
 * Class Client
 * @package Aml\Bundle\WebBundle\Google
 */
class Client
{
    private $logger;
    private $googleAppName;
    private $googleDevKey;

    private $client;

    /**
     * Client constructor.
     *
     * @param Logger $logger
     * @param string $googleAppName
     * @param string $googleDevKey
     */
    public function __construct(Logger $logger, string $googleAppName, string $googleDevKey)
    {
        $this->logger = $logger;
        $this->googleAppName = $googleAppName;
        $this->googleDevKey = $googleDevKey;
    }

    /**
     * Init Google client
     *
     * @return Google_Client
     */
    public function get()
    {
        try {
            $this->client = new Google_Client();
            $this->client->setApplicationName($this->googleAppName);
            $this->client->setDeveloperKey($this->googleDevKey);

            $this->logger->debug('GOOGLE CLIENT INIT : Success ');

            return $this->client;

        } catch (\Exception $e) {
            $this->logger->error('GOOGLE CLIENT INIT ERROR : ' . $e->getMessage());
            throw $e;
        }
    }
}
