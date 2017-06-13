<?php
namespace Aml\Bundle\EvenementsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * Class GoogleCalendarImportCommand
 * @package Aml\Bundle\EvenementsBundle\Command
 */
class GoogleCalendarImportCommand extends ContainerAwareCommand
{

    /**
     * @var Symfony\Component\Console\Output\OutputInterface
     */
    protected $output = null;

    protected $evenementRepo;
    protected $doctine;
    protected $entityManager;

    protected $googleCalendarProvider;

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('google:calendar:import-events')
            ->setDescription('Import events from Google Calendar')
            ->setHelp(
                <<<EOF
                The <info>google:calendar:import-events</info> Import events from Google Calendar and debug mode:

<info>php bin/console google:calendar:import-events -vvv</info>
EOF
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $this->doctrine = $this->getContainer()->get('doctrine');
        $this->entityManager = $this->doctrine->getManager('default');

        $this->evenementRepo = $this->doctrine->getRepository('AmlEvenementsBundle:Evenement');

        $this->googleCalendarProvider = $this->getContainer()->get('aml_medias.google.google_calendar_provider');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output->writeln('<info>Import Events from Google Calendar: Start</info>');

        foreach ($this->googleCalendarProvider->getEvents() as $event) {
            var_dump(
                '---',
                $event->getSummary(),
                $event->getStart()->getDateTime(),
                $event->getEnd()->getDateTime(),
                $event->getId()
            );
        }

        $this->output->writeln('<info>Import Events from Google Calendar: End</info>');
    }
}
