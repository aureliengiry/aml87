<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Command;

use App\Google\YoutubeProvider;
use App\Video\VideoFactory;
use App\Video\VideoManager;
use Doctrine\Common\Persistence\ObjectManager;
use Monolog\Logger;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
// logger
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UpdateYoutubeDataCommand.
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

    /** @var ObjectManager */
    private $em;

    /** @var array list of videos */
    private $videosList = [];

    /**
     * {@inheritdoc}
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
        if (true === $this->debug) {
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

        $youtubeProvider = $this->getContainer()->get(YoutubeProvider::class);

        $compteurVideo = 0;

        try {
            if ($playlistId = $youtubeProvider->getPlaylistUploadId()) {
                $videos = $youtubeProvider->getVideosPlaylist($playlistId);
                foreach ($videos->getItems() as $youtubeVideo) {
                    $idYoutube = $youtubeVideo->getContentDetails()->getVideoId();
                    if (!in_array($idYoutube, $this->videosList, true)) {
                        $video = $this->getContainer()->get(VideoFactory::class)->createVideoFromYoutube(
                            $youtubeVideo
                        );

                        $this->em->persist($video);
                        $output->writeln('Youtube ID: '.$idYoutube.' imported.');

                        ++$compteurVideo;
                    }
                }
                $this->em->flush();
            }
        } catch (\Exception $e) {
            $output->writeln('<bg=red;fg=white>Error: '.$e->getMessage().'</>');
        }

        $this->output->writeln("New videos: {$compteurVideo}");

        $output->writeln('<bg=cyan;fg=red>Fin du traitement</>');
    }

    /**
     * Get videos list.
     */
    private function initVideoslist()
    {
        $videos = $this->getContainer()->get(VideoManager::class)->findAllVideosYoutube();
        foreach ($videos as $video) {
            $this->videosList[$video->getId()] = $video->getProviderId();
        }

        $nbVideos = count($this->videosList);
        $this->output->writeln("Init videos: {$nbVideos}");
    }
}
