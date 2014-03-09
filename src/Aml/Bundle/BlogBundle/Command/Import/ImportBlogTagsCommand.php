<?php
/**
 * Import Blog contents from aml87.fr
 *
 * @author Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace Aml\Bundle\BlogBundle\Command\Import;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Aml\Bundle\BlogBundle\Entity\Tags;

/**
 * Class ImportBlogTagsCommand
 * @package Aml\Bundle\BlogBundle\Command\Import
 */
class ImportBlogTagsCommand extends ContainerAwareCommand
{
    protected $name;
    protected $dbh;
    protected $_oldData = array();

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('blog:import:tags')
            ->setDescription('Import Blog tags from old website')
            ->setHelp(<<<EOF
The <info>blog:import:tags</info> command imports blog categories from website aml87.fr and debug mode:

<info>php app/console blog:import:tags --debug</info>
EOF
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        var_dump(__METHOD__);
        $this->_loadData();
        var_dump($this->_oldData);
        $this->_importContent();
    }

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
     *  Load tags
     */
    protected function _loadData()
    {
        var_dump(__METHOD__);

        $this->_connectDb();

        // import vocabulary 2 ( Blog )
        $queryString = "SELECT *
		FROM term_data 		
		WHERE vid=3";
        $query = $this->dbh->query($queryString);

        $this->_oldData = $query->fetchAll();
    }

    /**
     * Import Content
     */
    protected function _importContent()
    {
        var_dump(__METHOD__);
        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');

        if (!empty($this->_oldData)) {
            foreach ($this->_oldData as $item) {
                $entity = new Tags();

                $entity
                    ->setName($item['name'])
                    ->setSystemName($item['name'])
                    ->setWeight($item['weight'])
                    ->setDescription($item['description']);

                $em->persist($entity);
                $em->flush();
            }
        }
    }

}