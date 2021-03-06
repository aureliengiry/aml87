<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class SendMessageCommandTest.
 */
class SendMessageCommandTest extends KernelTestCase
{
    /**
     * Test command without argument.
     *
     * @expectedException \Symfony\Component\Console\Exception\RuntimeException
     * @expectedExceptionMessage Not enough arguments (missing: "id-message").
     */
    public function testEmptyIdMessage()
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);
        $command = $application->find('contact-us:send:message');

        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
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
        $kernel = static::createKernel();
        $application = new Application($kernel);
        $command = $application->find('contact-us:send:message');

        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
            'id-message' => 999,
        ]);
    }
}
