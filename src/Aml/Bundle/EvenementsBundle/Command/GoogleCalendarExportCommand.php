<?php
namespace Aml\Bundle\EvenementsBundle\Command;

use Aml\Bundle\EvenementsBundle\Evenement\EvenementManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


/**
 * Class GoogleCalendarExportCommand
 * @package Aml\Bundle\EvenementsBundle\Command
 */
class GoogleCalendarExportCommand extends ContainerAwareCommand
{

    /**
     * @var Symfony\Component\Console\Output\OutputInterface
     */
    protected $output = null;
    protected $io;

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
            ->setName('google:calendar:export-events')
            ->setDescription('Export events to Google Calendar')
            ->setHelp(
                <<<EOF
                The <info>google:calendar:export-events</info> Export events to Google Calendar and debug mode:

<info>php bin/console google:calendar:export-events -vvv</info>
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

        $this->io = new SymfonyStyle($input, $output);

        $this->doctrine = $this->getContainer()->get('doctrine');
        $this->entityManager = $this->doctrine->getManager('default');

        $this->evenementManager = $this->getContainer()->get(EvenementManager::class);

        $this->googleCalendarProvider = $this->getContainer()->get('aml_medias.google.google_calendar_provider');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io->title('Export events to Google Calendar');

        foreach ($this->evenementManager->findAllConcerts() as $event) {
            dump($event);exit;


//            var_dump(
//                '---',
//                $event->getSummary(),
//                $event->getStart()->getDateTime(),
//                $event->getEnd()->getDateTime(),
//                $event->getId()
//            );
        }

        $this->output->writeln('<info>Import Events from Google Calendar: End</info>');
    }
}
