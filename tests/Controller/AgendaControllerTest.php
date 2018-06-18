<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AgendaControllerTest
 * @package Tests\Controller
 */
class AgendaControllerTest extends WebTestCase
{

    public function testArchivesWithoutSeason()
    {
        $client = static::createClient();

        $url = $client->getContainer()->get('router')->generate('agenda_archives', ['season_id' => 0]);
        $crawler = $client->request('GET', $url);

        // Check status code
        $this->assertSame(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
    }

//    public function testArchives()
//    {
//        $client = static::createClient();
//
//        $url = $client->getContainer()->get('router')->generate('agenda_archives');
//        $crawler = $client->request('GET', $url);
//
//        // Check status code
//        $this->assertEquals(200, $client->getResponse()->getStatusCode());
//
//        // Test Title
//        $this->assertTrue($crawler->filter('html:contains("Archives")')->count() > 0);
//    }
}
