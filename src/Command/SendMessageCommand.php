<?php

namespace App\Command;

use App\Entity\Message;
use App\Event\Contact\PostEvent;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class SendMessageCommand.
 */
class SendMessageCommand extends ContainerAwareCommand
{
    /**
     * @var MessageRepository
     */
    protected $messageRepo;
    protected $messageId;
    protected $doctrine;
    protected $entityManager;

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
        $this->doctrine = $this->getContainer()->get('doctrine');
        $this->entityManager = $this->doctrine->getManager('default');

        $this->messageRepo = $this->doctrine->getRepository(Message::class);

        $this->messageId = $input->getArgument('id-message');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Send message : Start</info>');

        // Load contact message
        $message = $this->messageRepo->find($this->messageId);
        if (!$message) {
            throw new NotFoundHttpException('Unable to find WebBundle:Message entity.');
        }

        $output->writeln('<info>'.$message->getName().' - '.$message->getSubject().'</info>');

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->getContainer()->get('event_dispatcher');
        $dispatcher->dispatch('aml_contactus.message.post_sent', new PostEvent($message));

        $output->writeln('<info>Send Message : End</info>');
    }
}
