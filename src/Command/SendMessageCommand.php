<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Command;

use App\Entity\Message;
use App\Event\Contact\PostEvent;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    /**
     * @var MessageRepository
     */
    protected $messageRepo;
    protected $messageId;

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    public function __construct(
        EntityManagerInterface $entityManager,
        EventDispatcherInterface $eventDispatcher)
    {
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;

        parent::__construct();
    }

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('contact-us:send:message')
            ->setDescription('Send message by id')
            ->setHelp(
                <<<EOF
                The <info>contact-us:send:message</info> send selected message by mail and debug mode:

<info>php bin/console contact-us:send:message -vvv</info>
EOF
            );

        $this->addArgument('id-message', InputArgument::REQUIRED, 'ID Message');
    }

    /**
     * {@inheritdoc}
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->messageRepo = $this->entityManager->getRepository(Message::class);
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
        if (!$message) {
            throw new NotFoundHttpException('Unable to find WebBundle:Message entity.');
        }

        $output->writeln('<info>'.$message->getName().' - '.$message->getSubject().'</info>');

        /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $this->eventDispatcher->dispatch('aml_contactus.message.post_sent', new PostEvent($message));

        $output->writeln('<info>Send Message : End</info>');

        return 0;
    }
}
