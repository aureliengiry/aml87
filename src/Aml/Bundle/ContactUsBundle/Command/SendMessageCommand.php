<?php
namespace Aml\Bundle\ContactUsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Aml\Bundle\ContactUsBundle\Entity\Message;
use Aml\Bundle\ContactUsBundle\Event\PostEvent;

/**
 * Class SeasonsCommand
 * @package Aml\Bundle\EvenementsBundle\Command
 */
class SendMessageCommand extends ContainerAwareCommand
{
    /**
     * @var Symfony\Component\Console\Output\OutputInterface
     */
    protected $output = null;

    protected $messageRepo;
    protected $messageId;
    protected $doctine;
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
        $this->output = $output;

        $this->doctrine = $this->getContainer()->get('doctrine');
        $this->entityManager = $this->doctrine->getManager('default');

        $this->messageRepo = $this->doctrine->getRepository('AmlContactUsBundle:Message');

        $this->messageId = $input->getArgument('id-message');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output->writeln('<info>Send message : Start</info>');

        // Load contact message
        $message = $this->messageRepo->find($this->messageId);
        if (!$message) {
            throw new NotFoundHttpException('Unable to find ContactUsBundle:Message entity.');
        }

        $this->output->writeln('<info>' . $message->getName() . ' - ' . $message->getSubject() . '</info>');

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->getContainer()->get('event_dispatcher');
        $dispatcher->dispatch('aml_contactus.message.post_sent', new PostEvent($message));


        $this->output->writeln('<info>Send Message : End</info>');
    }
}
