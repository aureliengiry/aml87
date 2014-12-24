<?php
/**
 * Import Images from old website
 *
 * @author Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace Tools\Bundle\MigrationBundle\Command\Import\Medias;

use Aml\Bundle\MediasBundle\Entity\Video\Youtube;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Tools\Bundle\MigrationBundle\Command\Import\AbstractCommand;

/**
 * Class ImportBlogCommand
 *
 * @package Aml\Bundle\BlogBundle\Command\Import
 */
class VideosCommand extends AbstractCommand
{
    protected $_oldVideos = array();

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('migration:import:blog-videos')
            ->setDescription('Import Blog images from old website')
            ->setHelp(<<<EOF
The <info>migration:import:blog-videos</info> command imports images from old website aml87.fr and debug mode:

<info>php app/console migration:import:blog-videos --debug</info>
EOF
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->_loadVideosArticles();
        $this->_importVideos();
    }

    /**
     * Load articles
     */
    protected function _loadVideosArticles()
    {
        $this->output->writeln('<info>Load videos of blog</info>');
        $queryString = "SELECT n.nid AS nodeId, n.title,cta.field_video_value as videoId
		FROM node n
		INNER JOIN content_type_article cta ON n.nid=cta.nid
		WHERE n.type='article' AND cta.field_video_embed IS NOT NULL";
        $query = $this->dbh->query($queryString);

        $this->_oldVideos = $query->fetchAll();
    }

    /**
     * Import images
     */
    protected function _importVideos()
    {
        $this->output->writeln('<info>Import videos :</info>');
        $em = $this->getContainer()->get('doctrine')->getManager('default');

        if (!empty($this->_oldVideos)) {
            foreach ($this->_oldVideos as $video) {

                $entityVideo = new Youtube();

                $entityVideo
                    ->setTitle(utf8_encode($video['title']))
                    ->setProviderId($video['videoId']);

                $em->persist($entityVideo);

                $this->output->writeln('<info>-' . utf8_decode($entityVideo->getTitle()) . ' (youtube: ' . $entityVideo->getProviderId() .')</info>');
            }

            $em->flush();
        }
    }

    /**
     * http://www.ficgs.com/How-to-remove-accents-in-PHP-f3057.html
     */
    protected function _build_category_name($string)
    {
        $string = str_replace(array('à', 'á', 'â', 'ã', 'ä', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý'), array('a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y'), $string);
        $string = str_replace(array(' ', '-'), array('_', '_'), $string);

        return strtolower($string);
    }

}