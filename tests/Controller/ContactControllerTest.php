<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ContactControllerTest.
 */
class ContactControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * Test contact Page.
     */
    public function testIndex()
    {
        $url = $this->client->getContainer()->get('router')->generate('aml_contactus_default_index');
        $crawler = $this->client->request(Request::METHOD_GET, $url);

        // Check status code
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertContains('Contactez-nous', $crawler->filter('title')->text());
    }

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
