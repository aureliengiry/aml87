<?php

namespace Tests\Aml\Bundle\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class BlogControllerTest
 * @package Aml\Bundle\BlogBundle\Tests\Controller
 */
class BlogControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $url = $client->getContainer()->get('router')->generate('blog');
        $crawler = $client->request('GET', $url);

        // Check status code
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Check page title
        $this->assertContains('Blog', $crawler->filter('title')->text());

        // Check if there is at least one article
        //$this->assertTrue($crawler->filter('#col-left .contenu-page article')->count() > 0);
    }
}
