<?php
namespace Tests\Aml\Bundle\WebBundle\Command;

use Aml\Bundle\WebBundle\Command\SendMessageCommand;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class SendMessageCommandTest extends KernelTestCase
{
    /**
     * Test command without argument
     *
     * @expectedException Symfony\Component\Console\Exception\RuntimeException
     * @expectedExceptionMessage Not enough arguments (missing: "id-message").
     */
    public function testEmptyIdMessage()
    {
        self::bootKernel();
        $application = new Application(self::$kernel);
        $application->add(new SendMessageCommand());
        $command = $application->find('contact-us:send:message');

        $commandTester = new CommandTester($command);
        $commandTester->execute(
            array(
                'command' => $command->getName(),
            )
        );
    }

    /**
     * Test command with wrong id message
     *
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @expectedExceptionMessage Unable to find WebBundle:Message entity
     */
    public function testWrongIdMessage(){

        self::bootKernel();
        $application = new Application(self::$kernel);
        $application->add(new SendMessageCommand());
        $command = $application->find('contact-us:send:message');

        $commandTester = new CommandTester($command);
        $commandTester->execute(
            array(
                'command' => $command->getName(),
                'id-message' => 999
            )
        );
    }
}