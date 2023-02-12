<?php

declare(strict_types=1);

namespace App\Tests\Controller\MembersArea;

use App\DataFixtures\UserFixtures;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * @group functional
 * @group members-area
 */
class MembersControllerTest extends WebTestCase
{
    private ?KernelBrowser $client = null;
    private ?UserRepository $userRepository = null;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->userRepository = static::getContainer()->get(UserRepository::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->client = null;
        $this->userRepository = null;
    }

    /**
     * Test Login redirect.
     */
    public function testMembersAreaWithoutLogging(): void
    {
        $this->client->request('GET', '/fr/espace-membres');
        $this->assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->client->getResponse()->isRedirect());

        $crawler = $this->client->followRedirect();
        $this->assertStringContainsString('Connexion', $crawler->filter('title')->text());
    }

    /**
     * Test Home page with user login.
     */
    public function testMembersAreaWithLogging(): void
    {
        $this->logIn();

        $this->client->request('GET', '/fr/espace-membres');
        $crawler = $this->client->followRedirect();

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertStringContainsString('Espace membres', $crawler->filter('title')->text());
    }

    private function logIn(): void
    {
        $session = $this->client->getContainer()->get('session');

        // the firewall context (defaults to the firewall name)
        $firewall = 'main';

        $user = $this->createMock(User::class);
        $user->method('getId')->willReturn(3);
        $user->method('getUsername')->willReturn('testor');

        // $user = new User();
        // $user->setUsername('toto');

        $user = $this->userRepository->findOneBy(['username' => UserFixtures::SIMPLE_USER]);

        $token = new UsernamePasswordToken($user, '', $firewall, ['ROLE_USER']);
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}
