<?php
namespace Aml\Bundle\MediasBundle\Google;

use Aml\Bundle\MediasBundle\Google\Client;
use Google_Client;

/**
 * Class GoogleCalendarProvider
 * @package Aml\Bundle\MediasBundle\Google
 */
class GoogleCalendarProvider
{
    /** @var Client */
    private $googleClient;

    private $googleCalendarService;

    private $googleCalendarId;

    /**
     * GoogleCalendarProvider constructor.
     *
     * @param Client $googleClient
     * @param string $youtubeUsername
     */
    public function __construct(Client $googleClient, string $googleCalendarId)
    {
        $this->googleClient = $googleClient;
        $this->googleCalendarId = $googleCalendarId;
    }

    public function init()
    {
        $client = $this->googleClient->get();
        $client->addScope(\Google_Service_Calendar::CALENDAR_READONLY);

        $this->googleCalendarService = new \Google_Service_Calendar($client);
    }

    public function getEvents(int $maxResults = 10)
    {
        $this->init();

        $params = array(
            'maxResults'   => $maxResults,
            'orderBy'      => 'startTime',
            'singleEvents' => true,
            'timeMin'      => date('c'),
        );

        return $this->googleCalendarService->events->listEvents($this->googleCalendarId, $params);

    }
}
