<?php

namespace Tests\Aml\Bundle\EvenementsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AgendaControllerTest extends WebTestCase
{
    public function testArchives()
    {
        $client = static::createClient();

        $url = $client->getContainer()->get('router')->generate('agenda_archives');
        $crawler = $client->request('GET', $url);

        // Check status code
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Test Title
        $this->assertTrue($crawler->filter('html:contains("Archives")')->count() > 0);
    }
}
