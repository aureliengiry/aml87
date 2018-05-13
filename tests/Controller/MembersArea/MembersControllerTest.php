<?php

namespace Tests\App\Controller\MembersArea;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Class MembersControllerTest
 * @package Tests\App\Controller\MembersArea
 *
 * @group functional
 * @group members-area
 */
class MembersControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * Test Login redirect
     */
    public function testMembersAreaWithoutLogging()
    {
        $this->client->request('GET', '/espace-membres');
        $this->assertEquals(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->client->getResponse()->isRedirect());

        $crawler = $this->client->followRedirect();
        $this->assertContains('Connexion', $crawler->filter('title')->text());
    }

    /**
     * Test Home page with user login
     */
    public function testMembersAreaWithLogging()
    {
        $this->logIn();

        $this->client->request('GET', '/espace-membres');
        $crawler = $this->client->followRedirect();

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
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
        $session->set('_security_' . $firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}
