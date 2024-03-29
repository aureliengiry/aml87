<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @group functional
 */
class BlogControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();

        $url = $client->getContainer()->get('router')->generate('blog');
        $crawler = $client->request('GET', $url);

        // Check status code
        $this->assertSame(\Symfony\Component\HttpFoundation\Response::HTTP_OK, $client->getResponse()->getStatusCode());

        // Check page title
        $this->assertStringContainsString('Blog', $crawler->filter('title')->text());

        // Check if there is at least one article
        // $this->assertTrue($crawler->filter('#col-left .contenu-page article')->count() > 0);
    }
}
