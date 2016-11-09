<?php
namespace Tests\ContactUsBundle\Command;

use Aml\Bundle\ContactUsBundle\Command\SendMessageCommand;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Tester\CommandTester;

use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SendMessageCommandTest extends KernelTestCase
{
    /**
     * Test command without argument
     *
     * @expectedException RuntimeException
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
     * @expectedException NotFoundHttpException
     * @expectedExceptionMessage Unable to find ContactUsBundle:Message entity
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
                'id-message' => 5
            )
        );
    }


}
