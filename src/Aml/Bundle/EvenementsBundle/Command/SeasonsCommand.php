<?php
/**
 * Import Blog contens from aml87.fr
 *
 * @author Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace Aml\Bundle\EvenementsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Aml\Bundle\EvenementsBundle\Entity\Evenement;
use Aml\Bundle\EvenementsBundle\Entity\Season;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Class SeasonsCommand
 * @package Aml\Bundle\EvenementsBundle\Command
 */
class SeasonsCommand extends ContainerAwareCommand
{
    /**
     * @var Symfony\Component\Console\Input\InputInterface
     */
    protected $input = null;

    /**
     * @var Symfony\Component\Console\Output\OutputInterface
     */
    protected $output = null;

    protected $evenementRepo;
    protected $seasonRepo;
    protected $doctine;
    protected $entityManager;

    /**
     * Validate entry
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws \RunTimeException
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $this->doctrine = $this->getContainer()->get('doctrine');
        $this->entityManager = $this->doctrine->getManager('default');

        $this->evenementRepo = $this->doctrine->getRepository('AmlEvenementsBundle:Evenement');
        $this->seasonRepo = $this->doctrine->getRepository('AmlEvenementsBundle:Season');
    }

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('evenements:index:seasons')
            ->setDescription('Index seasons for all events')
            ->setHelp(
                <<<EOF
                The <info>evenements:index:seasons</info> Index seasons for all events and debug mode:

<info>php app/console evenements:index:seasons -vvv</info>
EOF
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output->writeln('<info>Indexation evenements/seasons: Start</info>');

        // Build Current Date
        $currentDateTime = new \DateTime();
        $currentDateTime->setTime(0, 0);

        $estimateCurrentSeason = $this->calculateSeason($currentDateTime);

        // Get list of event
        $evenements = $this->evenementRepo->findAll();

        foreach ($evenements as $event) {
            $this->getSeasonByEvent($event);

            // Archive event
            if ($event->getSeason() != $estimateCurrentSeason) {
                $event->setArchive(true);
            } else {
                $event->setArchive(false);
            }

            $this->entityManager->persist($event);
        }

        $this->entityManager->flush();

        $this->output->writeln('<info>Indexation evenements/seasons: End</info>');
    }

    /**
     * @param Evenement $event
     */
    protected function getSeasonByEvent(Evenement &$event)
    {
        $eventDateStart = $event->getDateStart();
        if ($eventDateStart) {
            $estimateSeason = $this->calculateSeason($eventDateStart);

            // Check current season of event
            $eventHasSeason = $event->hasSeason();
            if (true === $eventHasSeason) {
                // Check if it's good season or not
                if ($event->getSeason() != $estimateSeason) {
                    // if it's wrong update
                    $event->setSeason($estimateSeason);
                }
            } else {
                // Update event
                $event->setSeason($estimateSeason);
            }
        } else {
            $this->output->writeln('<info>Date Start is empty for this event: '.$event->getId().'</info>');
        }
    }

    /**
     * @param \DateTime $eventDateStart
     * @return Season
     */
    protected function calculateSeason(\DateTime $eventDateStart)
    {
        $estimateSeason = $this->seasonRepo->getSeasonByDateStart($eventDateStart);
        if ($estimateSeason) {
            return $estimateSeason;
        } else {
            $defaultDateStart = Season::SEASON_DEFAULT_DATE_START;
            $eventDateStartYear = (int)$eventDateStart->format('Y');
            $testDateStart = sprintf($defaultDateStart, $eventDateStartYear);

            // Build Test Date
            $testDateTime = \DateTime::createFromFormat('Y-m-d', $testDateStart);
            $testDateTime->setTime(0, 0);

            if ($eventDateStart < $testDateTime) {
                // Build Season Date Start
                $seasonDateStartYear = $eventDateStartYear - 1;
                $dateStart = sprintf($defaultDateStart, $seasonDateStartYear);
                $seasonDateStart = \DateTime::createFromFormat('Y-m-d', $dateStart);
                $seasonDateStart->setTime(0, 0);

                // Build Season Date End
                $defaultDateEnd = Season::SEASON_DEFAULT_DATE_END;
                $eventDateEndYear = (int)$eventDateStart->format('Y');
                $testDateEnd = sprintf($defaultDateEnd, $eventDateEndYear);

                $seasonDateEndYear = $eventDateStartYear;
                $seasonDateEnd = \DateTime::createFromFormat('Y-m-d', $testDateEnd);
                $seasonDateEnd->setTime(0, 0);

                // Build season name
                $seasonName = "Saison $seasonDateStartYear/$seasonDateEndYear";
            } else {
                // Build Season Date Start
                $seasonDateStart = $testDateTime;
                $seasonDateStartYear = (int)$seasonDateStart->format('Y');

                // Build Season Date End
                $seasonDateEndYear = $seasonDateStartYear + 1;
                $defaultDateEnd = Season::SEASON_DEFAULT_DATE_END;
                $testDateEnd = sprintf($defaultDateEnd, $seasonDateEndYear);

                $seasonDateEnd = \DateTime::createFromFormat('Y-m-d', $testDateEnd);
                $seasonDateEnd->setTime(0, 0);

                // Build season name
                $seasonName = "Saison $seasonDateStartYear/$seasonDateEndYear";
            }

            // Create new Season
            $estimateSeason = new Season();
            $estimateSeason
                ->setName($seasonName)
                ->setDateStart($seasonDateStart)
                ->setDateEnd($seasonDateEnd);

            $this->entityManager->persist($estimateSeason);
            $this->entityManager->flush();

            return $estimateSeason;
        }

    }

}