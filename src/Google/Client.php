<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Google;

use Google_Client;
use Psr\Log\LoggerInterface;

/**
 * Class Client.
 */
class Client
{
    private LoggerInterface $logger;
    private string $googleAppName;
    private string $googleDevKey;

    private ?Google_Client $client = null;

    /**
     * Client constructor.
     */
    public function __construct(LoggerInterface $logger, string $googleAppName, string $googleDevKey)
    {
        $this->logger = $logger;
        $this->googleAppName = $googleAppName;
        $this->googleDevKey = $googleDevKey;
    }

    /**
     * Init Google client.
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
            $this->logger->error('GOOGLE CLIENT INIT ERROR : '.$e->getMessage());
            throw $e;
        }
    }
}
