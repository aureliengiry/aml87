<?php

declare(strict_types=1);

/**
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>.
 */

namespace App\Command;

use App\Google\YoutubeProvider;
use App\Video\VideoFactory;
use App\Video\VideoManager;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateYoutubeDataCommand extends Command
{
    final public const YOUTUBE_STATUS_PUBLIC = 'public';
    final public const YOUTUBE_STATUS_UNLISTED = 'unlisted';

    private bool $debug = false;

    private OutputInterface $output;

    private array $videosList = [];

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly YoutubeProvider $youtubeProvider,
        private readonly VideoFactory $videoFactory,
        private readonly VideoManager $videoManager,
        private readonly LoggerInterface $logger
    ) {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
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
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->debug = $input->getOption('debug');

        $this->output = $output;

        if (true === $this->debug) {
            $this->logger->pushProcessor(new MemoryPeakUsageProcessor());
            $this->logger->pushProcessor(new MemoryUsageProcessor());
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<bg=cyan;fg=red>Start treatment </>');

        $this->initVideoslist();

        $compteurVideo = 0;

        try {
            if ($playlistId = $this->youtubeProvider->getPlaylistUploadId()) {
                $videos = $this->youtubeProvider->getVideosPlaylist($playlistId);
                foreach ($videos->getItems() as $youtubeVideo) {
                    $idYoutube = $youtubeVideo->getContentDetails()->getVideoId();
                    if ( ! \in_array($idYoutube, $this->videosList, true)) {
                        $video = $this->videoFactory->createVideoFromYoutube(
                            $youtubeVideo
                        );

                        $this->entityManager->persist($video);
                        $output->writeln('Youtube ID: '.$idYoutube.' imported.');

                        ++$compteurVideo;
                    }
                }
                $this->entityManager->flush();
            }
        } catch (\Exception $e) {
            $output->writeln('<bg=red;fg=white>Error: '.$e->getMessage().'</>');
        }

        $this->output->writeln("New videos: {$compteurVideo}");

        $output->writeln('<bg=cyan;fg=red>Fin du traitement</>');

        return 0;
    }

    /**
     * Get videos list.
     */
    private function initVideoslist(): void
    {
        $videos = $this->videoManager->findAllVideosYoutube();
        foreach ($videos as $video) {
            $this->videosList[$video->getId()] = $video->getProviderId();
        }

        $nbVideos = \count($this->videosList);
        $this->output->writeln("Init videos: {$nbVideos}");
    }
}
