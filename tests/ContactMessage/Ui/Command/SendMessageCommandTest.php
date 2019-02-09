<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace Tests\ContactMessage\Ui\Command;

use App\ContactMessage\Ui\Command\SendMessageCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class SendMessageCommandTest.
 */
class SendMessageCommandTest extends KernelTestCase
{
    /** @var SendMessageCommand */
    private $command;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        self::bootKernel();
        $application = new Application(self::$kernel);
        $application->add(static::$kernel->getContainer()->get('test.'.SendMessageCommand::class));
        $this->command = $application->find('contact-us:send:message');
    }

    /**
     * Test command without argument.
     *
     * @expectedException \Symfony\Component\Console\Exception\RuntimeException
     * @expectedExceptionMessage Not enough arguments (missing: "id-message").
     */
    public function testEmptyIdMessage()
    {


        $commandTester = new CommandTester($this->command);
        $commandTester->execute([
            'command' => $this->command->getName(),
        ]);
    }

    /**
     * Test command with wrong id message.
     *
     * @expectedException \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @expectedExceptionMessage Unable to find WebBundle:Message entity
     */
    public function testWrongIdMessage()
    {
        $commandTester = new CommandTester($this->command);
        $commandTester->execute([
            'command' => $this->command->getName(),
            'id-message' => 999,
        ]);
    }
}
