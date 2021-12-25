<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class SendMessageCommandTest.
 */
class SendMessageCommandTest extends KernelTestCase
{
    /**
     * Test command without argument.
     */
    public function testEmptyIdMessage(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Not enough arguments (missing: "id-message").');

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
     */
    public function testWrongIdMessage(): void
    {
        $this->expectException(NotFoundHttpException::class);
        $this->expectExceptionMessage('Unable to find WebBundle:Message entity');

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
