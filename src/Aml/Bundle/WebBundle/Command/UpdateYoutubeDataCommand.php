<?php
namespace Aml\Bundle\WebBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// logger
use Monolog\Logger;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\MemoryUsageProcessor;

/**
 * Class UpdateYoutubeDataCommand
 * @package Aml\Bundle\WebBundle\Command
 */
class UpdateYoutubeDataCommand extends ContainerAwareCommand
{
    const YOUTUBE_STATUS_PUBLIC = 'public';
    const YOUTUBE_STATUS_UNLISTED = 'unlisted';

    /** @var bool debug mode */
    private $debug = false;
    
    private $output;

    /** @var Logger command logger */
    private $logger;

    /** @var EntityManager */
    private $em;

    /** @var array list of videos */
    private $videosList = [];


    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName('medias:youtube:update-videos')
            ->setDescription('Update videos data from Youtube.')
            ->setHelp('');

        $this->getDefinition()->addOptions(
            [
                new InputOption('debug', null, InputOption::VALUE_NONE, 'Show Message'),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->debug = $input->getOption('debug');

        $this->output = $output;

        // Logger
        $this->logger = $this->getContainer()->get('logger');
        if ($this->debug === true) {
            $this->logger->pushProcessor(new MemoryPeakUsageProcessor());
            $this->logger->pushProcessor(new MemoryUsageProcessor());
        }

        $this->em = $this->getContainer()->get('doctrine')->getManager('default');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<bg=cyan;fg=red>Start treatment </>');

        $this->initVideoslist();

        $youtubeProvider = $this->getContainer()->get('aml_medias.google.youtube_provider');

        $compteurVideo = 0;

        try {
            if ($playlistId = $youtubeProvider->getPlaylistUploadId()) {
                $videos = $youtubeProvider->getVideosPlaylist($playlistId);
                foreach ($videos->getItems() as $youtubeVideo) {
                    $idYoutube = $youtubeVideo->getContentDetails()->getVideoId();
                    if (!in_array($idYoutube, $this->videosList)) {
                        $video = $this->getContainer()->get('aml_medias.video.video_factory')->createVideoFromYoutube(
                            $youtubeVideo
                        );

                        $this->em->persist($video);
                        $output->writeln('Youtube ID: ' . $idYoutube . ' imported.');

                        $compteurVideo++;
                    }

                }
                $this->em->flush();
            }
        } catch (\Exception $e) {
            $output->writeln('<bg=red;fg=white>Error: ' . $e->getMessage() . '</>');
        }

        $this->output->writeln("New videos: {$compteurVideo}");


        $output->writeln('<bg=cyan;fg=red>Fin du traitement</>');
    }

    /**
     * Get videos list
     */
    private function initVideoslist()
    {
        $videos = $this->getContainer()->get('aml_medias.video.video_manager')->findAllVideosYoutube();
        foreach ($videos as $video) {
            $this->videosList[$video->getId()] = $video->getProviderId();
        }

        $nbVideos = count($this->videosList);
        $this->output->writeln("Init videos: {$nbVideos}");
    }
}
