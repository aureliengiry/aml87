<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Command;

use App\Entity\Message;
use App\Event\Contact\MessageSaved;
use App\Repository\MessageRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class SendMessageCommand.
 */
class SendMessageCommand extends Command
{
    private ?int $messageId = null;

    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly MessageRepository $messageRepo
    ) {
        parent::__construct();
    }

    /**
     * @see Command
     */
    protected function configure(): void
    {
        $this
            ->setName('contact-us:send:message')
            ->setDescription('Send message by id')
            ->setHelp(
                <<<EOF
                                    The <info>contact-us:send:message</info> send selected message by mail and debug mode:

                    <info>bin/console contact-us:send:message -vvv</info>
                    EOF
            );

        $this->addArgument('id-message', InputArgument::REQUIRED, 'ID Message');
    }

    /**
     * {@inheritdoc}
     */
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->messageId = $input->getArgument('id-message');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<info>Send message : Start</info>');

        // Load contact message
        $message = $this->messageRepo->find($this->messageId);
        if ( ! $message) {
            throw new NotFoundHttpException('Unable to find message with id: '.$this->messageId);
        }

        $output->writeln('<info>'.$message->getName().' - '.$message->getSubject().'</info>');

        /* @todo to refactor, no action before dispatch */
        $this->eventDispatcher->dispatch(new MessageSaved($message));

        $output->writeln('<info>Send Message : End</info>');

        return 0;
    }
}
