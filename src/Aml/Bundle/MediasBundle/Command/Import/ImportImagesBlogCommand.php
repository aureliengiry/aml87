<?php
/**
 * Import Blog contens from aml87.fr
 *
 * @author Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace Aml\Bundle\MediasBundle\Command\Import;

use Aml\Bundle\MediasBundle\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Aml\Bundle\BlogBundle\Entity\Article;

/**
 * Class ImportBlogCommand
 * @package Aml\Bundle\BlogBundle\Command\Import
 */
class ImportImagesBlogCommand extends ContainerAwareCommand
{
    protected $name;
    protected $dbh;
    protected $_oldImages = array();

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('medias:import:imagesBlog')
            ->setDescription('Import Blog images from old website')
            ->setHelp(<<<EOF
The <info>blog:import:articles</info> command imports blog contents from website aml87.fr and debug mode:

<info>php app/console medias:import:imagesBlog --debug</info>
EOF
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        var_dump(__METHOD__);
        $this->_loadImagesArticles();
        var_dump($this->_oldImages);
        $this->_importImages();
    }

    /**
     * Connect to database
     */
    protected function _connectDb()
    {
        $dbInfo['database_target'] = $this->getContainer()->getParameter('database_host');
        $dbInfo['database_name'] = $this->getContainer()->getParameter('drupal_database_name');
        $dbInfo['username'] = $this->getContainer()->getParameter('database_user');
        $dbInfo['password'] = $this->getContainer()->getParameter('database_password');

        $dbConnString = "mysql:host=" . $dbInfo['database_target'] . "; dbname=" . $dbInfo['database_name'];
        $this->dbh = new \PDO($dbConnString, $dbInfo['username'], $dbInfo['password']);
        $this->dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $error = $this->dbh->errorInfo();
        if ($error[0] != "") {
            print "<p>DATABASE CONNECTION ERROR:</p>";
            print_r($error);
        }
    }

    /**
     * Load articles
     */
    protected function _loadImagesArticles()
    {
        var_dump(__METHOD__);

        $this->_connectDb();

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
        var_dump(__METHOD__);
        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');

        if (!empty($this->_oldImages)) {
            foreach ($this->_oldImages as $image) {

                $entityImage = new Image();

                $entityImage
                    ->setTitle(utf8_encode($image['title']))
                    ->setPath(utf8_encode($image['path']))
                ;

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