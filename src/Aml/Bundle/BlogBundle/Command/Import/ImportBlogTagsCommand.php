<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aml\Bundle\BlogBundle\Command\Import;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\KernelInterface;

use Aml\Bundle\BlogBundle\Entity\BlogTags;


/**
 * Import Blog contents from aml87.fr
 *
 * @author Aurélien GIRY <aurelien.giry@gmail.com>
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
//            ->setDefinition(array(
//                new InputOption('no-warmup', '', InputOption::VALUE_NONE, 'Do not warm up the cache'),
//            ))
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
        $dbInfo['database_target'] = $this->getContainer()->getParameter('import_database_host');
        $dbInfo['database_name'] = $this->getContainer()->getParameter('import_database_name');
        $dbInfo['username'] = $this->getContainer()->getParameter('import_database_user');
        $dbInfo['password'] = $this->getContainer()->getParameter('import_database_password');

        $dbConnString = "mysql:host=" . $dbInfo['database_target'] . "; dbname=" . $dbInfo['database_name'];
        $this->dbh = new \PDO($dbConnString, $dbInfo['username'], $dbInfo['password']);
        $this->dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $error = $this->dbh->errorInfo();
        if ($error[0] != "") {
            print "<p>DATABASE CONNECTION ERROR:</p>";
            print_r($error);
        }
    }

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

    protected function _importContent()
    {
        var_dump(__METHOD__);
        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');

        if (!empty($this->_oldData)) {
            foreach ($this->_oldData as $item) {
                $entity = new BlogTags();

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