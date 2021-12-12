<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Tests\Controller\MembersArea;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Class MembersControllerTest.
 *
 * @group functional
 * @group members-area
 */
class MembersControllerTest extends WebTestCase
{
    private $client = null;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->client = null;
    }

    /**
     * Test Login redirect.
     */
    public function testMembersAreaWithoutLogging()
    {
        $this->client->request('GET', '/espace-membres');
        $this->assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->client->getResponse()->isRedirect());

        $crawler = $this->client->followRedirect();
        $this->assertContains('Connexion', $crawler->filter('title')->text());
    }

    /**
     * Test Home page with user login.
     */
    public function testMembersAreaWithLogging()
    {
        $this->logIn();

        $this->client->request('GET', '/espace-membres');
        $crawler = $this->client->followRedirect();

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertContains('Espace membres', $crawler->filter('title')->text());
    }

    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        // the firewall context (defaults to the firewall name)
        $firewall = 'main';

        $user = $this->createMock(User::class);
        $user->method('getId')->willReturn(3);
        $user->method('getUsername')->willReturn('testor');

        //$user = new User();
        //$user->setUsername('toto');

        $token = new UsernamePasswordToken($user, '', $firewall, ['ROLE_USER']);
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}
