<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ContactControllerTest.
 *
 * @group functional
 */
class ContactControllerTest extends WebTestCase
{
    private ?KernelBrowser $client = null;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->client = null;
    }

    /*
     * Test contact Page.
     */
//    public function testIndex(): void
//    {
//        $url = $this->client->getContainer()->get('router')->generate('aml_contactus_default_index');
//        $crawler = $this->client->request(Request::METHOD_GET, $url);
//
//        // Check status code
//        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
//        $this->assertStringContainsString('Contactez-nous', $crawler->filter('title')->text());
//    }

    /*
     * Test post contact form
     */
//    public function testPostForm()
//    {
//        $url = $this->client->getContainer()->get('router')->generate('aml_contactus_default_index');
//        $crawler = $this->client->request('GET', $url);
//
//        // Check if form exist
//        $this->assertCount(1, $crawler->filter('form'));
//
//        // Select form
//        $form = $crawler->selectButton('message[send]')->form();
//
//        // set some values
//        $form['message[name]'] = 'Aurelien';
//        $form['message[email]'] = 'aurelien.giry@gmail.com';
//        $form['message[subject]'] = 'test';
//        $form['message[body]'] = 'test dsmljf msldjsqdlm jfmsljfqslf';
//
//        // submit the form
//        $this->client->submit($form);
//
//        // Follow Redirection
//        $crawler = $this->client->followRedirect();
//
//        // Check status code
//        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
//
//        // Check success message
//        $this->assertContains('E-mail envoyé avec succès', $crawler->filter('#contenu .alert')->text());
//    }
}
