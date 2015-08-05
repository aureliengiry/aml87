<?php
/**
 * Import Images from old website
 *
 * @author Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace Tools\Bundle\MigrationBundle\Command\Import\Medias;

use Aml\Bundle\MediasBundle\Entity\Image;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Tools\Bundle\MigrationBundle\Command\Import\AbstractCommand;

/**
 * Class ImportBlogCommand
 *
 * @package Aml\Bundle\BlogBundle\Command\Import
 */
class ImagesCommand extends AbstractCommand
{
    protected $name;
    protected $_oldImages = array();

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('migration:import:blog-images')
            ->setDescription('Import Blog images from old website')
            ->setHelp(<<<EOF
The <info>migration:import:blog-images</info> command imports images from old website aml87.fr and debug mode:

<info>php app/console migration:import:blog-images --debug</info>
EOF
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->_loadImagesArticles();
        $this->_importImages();
    }

    /**
     * Load articles
     */
    protected function _loadImagesArticles()
    {
        $this->output->writeln('<info>Load images of blog</info>');
        $queryString = "SELECT filename as title, filename as path
		FROM files f
		WHERE filemime like 'image%'";
        $query = $this->dbh->query($queryString);

        $this->_oldImages = $query->fetchAll();
    }

    /**
     * Import images
     */
    protected function _importImages()
    {
        $this->output->writeln('<info>Import images :</info>');
        $em = $this->getContainer()->get('doctrine')->getManager('default');

        if (!empty($this->_oldImages)) {
            foreach ($this->_oldImages as $image) {

                $entityImage = new Image();

                $entityImage
                    ->setTitle(utf8_encode($image['title']))
                    ->setPath(utf8_encode($image['path']));

                $em->persist($entityImage);
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