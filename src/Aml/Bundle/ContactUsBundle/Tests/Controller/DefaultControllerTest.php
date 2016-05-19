<?php

namespace Aml\Bundle\ContactUsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class DefaultControllerTest
 * @package Aml\Bundle\ContactUsBundle\Tests\Controller
 */
class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $url = $client->getContainer()->get('router')->generate('aml_contact_us_index');
        $crawler = $client->request('GET', $url);

        // Check status code
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Check if form exist
        $this->assertCount(1, $crawler->filter('form'));

        // Select form
        $form = $crawler->selectButton('aml_bundle_ContactUsBundle_messagetype[send]')->form();

        // set some values
        $form['aml_bundle_ContactUsBundle_messagetype[name]'] = 'Aurelien';
        $form['aml_bundle_ContactUsBundle_messagetype[email]'] = 'aurelien.giry@gmail.com';
        $form['aml_bundle_ContactUsBundle_messagetype[subject]'] = 'test';
        $form['aml_bundle_ContactUsBundle_messagetype[body]'] = 'test dsmljf msldjsqdlm jfmsljfqslf';

        // submit the form
        $crawler = $client->submit($form);

        // Follow Redirection
        $crawler = $client->followRedirect();

        // Check status code
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Check success message
        $this->assertContains('E-mail envoyé avec succès', $crawler->filter('#contenu .alert')->text());
    }
}
