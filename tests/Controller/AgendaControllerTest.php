<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AgendaControllerTest.
 */
class AgendaControllerTest extends WebTestCase
{
    public function testAgenda(): void
    {
        $client = static::createClient();

        $url = $client->getContainer()->get('router')->generate('agenda');
        $crawler = $client->request('GET', $url);

        // Check status code
        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testArchivesWithoutSeason(): void
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
