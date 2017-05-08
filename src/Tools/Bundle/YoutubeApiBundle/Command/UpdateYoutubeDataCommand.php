<?php
namespace Tools\Bundle\YoutubeApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// logger
use Monolog\Logger;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\MemoryUsageProcessor;

// Google API
use Google_Client;
use Google_Service_YouTube;

use Aml\Bundle\MediasBundle\Entity\Video\Youtube;

/**
 * Class UpdateYoutubeDataCommand
 *
 * @category    Mongobox
 * @package     Mongobox\Bundle\JukeboxBundle\Command
 */
class UpdateYoutubeDataCommand extends ContainerAwareCommand
{
    const YOUTUBE_STATUS_PUBLIC = 'public';
    const YOUTUBE_STATUS_UNLISTED = 'unlisted';

    /** @var bool debug mode */
    private $debug = false;

    /** @var Logger command logger */
    private $logger;

    /** @var EntityManager */
    private $em;

    /** @var array list of videos */
    private $videosList = array();


    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName('tools:youtubeApi:update')
            ->setDescription('Update videos data from Youtube.')
            ->setHelp('');

        $this->getDefinition()->addOptions(
            array(
                new InputOption('debug', null, InputOption::VALUE_NONE, 'Show Message'),
            )
        );
    }

    /**
     * Call before execute
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->debug = $input->getOption('debug');

        $this->googleAppName = $this->getContainer()->getParameter('google_app_name');
        $this->googleDeveloperKey = $this->getContainer()->getParameter('google_developer_key');

        $this->input = $input;
        $this->output = $output;

        // Logger
        $this->logger = $this->getContainer()->get('logger');
        if ($this->debug === true) {
            $this->logger->pushProcessor(new MemoryPeakUsageProcessor());
            $this->logger->pushProcessor(new MemoryUsageProcessor());
        }

        $this->em = $this->getContainer()->get('doctrine')->getManager('default');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<bg=cyan;fg=red>Start treatment </>');

        $this->initVideoslist();

        $client = new Google_Client();
        $client->setApplicationName($this->googleAppName);
        $client->setDeveloperKey($this->googleDeveloperKey);

        $youtube = new Google_Service_YouTube($client);

        $compteurVideo = 0;

        try {
            $playlists = $youtube->channels->listChannels("contentDetails", array('forUsername' => 'aml87170'));
            foreach ($playlists->getItems() as $item) {
                $playlistId = $item['contentDetails']['relatedPlaylists']['uploads'];
                break;
            }

            $videos = $youtube->playlistItems->listPlaylistItems(
                "snippet,contentDetails",
                array('playlistId' => $playlistId, 'maxResults' => 50)
            );
            foreach ($videos->getItems() as $youtubeVideo) {

                $snippet = $youtubeVideo->getSnippet();
                $contentDetails = $youtubeVideo->getContentDetails();

                $idYoutube = $contentDetails->getVideoId();
                if (!in_array($idYoutube, $this->videosList)) {
                    $video = new Youtube();
                    $video
                        ->setTitle($snippet->getTitle())
                        ->setProviderId($idYoutube);
                    $this->em->persist($video);

                    $output->writeln('Youtube ID: ' . $contentDetails->getVideoId() . ' imported.');

                    $compteurVideo++;
                }

            }
            $this->em->flush();
        } catch (\Exception $e) {
            $output->writeln('<bg=red;fg=white>Error: ' . $e->getMessage() . '</>');
        }

        $this->output->writeln("New videos: {$compteurVideo}");


        $output->writeln('<bg=cyan;fg=red>Fin du traitement</>');
    }

    private function initVideoslist()
    {
        $videos = $this->em->getRepository('AmlMediasBundle:Video\Youtube')->findAll();
        foreach ($videos as $video) {
            $this->videosList[$video->getId()] = $video->getProviderId();
        }

        $nbVideos = count($this->videosList);
        $this->output->writeln("Init videos: {$nbVideos}");

    }

}
