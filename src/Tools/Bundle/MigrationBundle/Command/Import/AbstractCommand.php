<?php
/**
 * Import Blog contens from aml87.fr
 *
 * @author Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace Tools\Bundle\MigrationBundle\Command\Import;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class AbstractCommand
 * @package Tools\Bundle\MigrationBundle\Command\Import\Blog
 */
abstract class AbstractCommand extends ContainerAwareCommand
{
    /**
     * @var Symfony\Component\Console\Input\InputInterface
     */
    protected $input = null;

    /**
     * @var Symfony\Component\Console\Output\OutputInterface
     */
    protected $output = null;

    protected $dbh = false;

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

        // Connect to source database
        $this->_connectDb();
    }

    /**
     * Connect to database
     */
    protected function _connectDb()
    {
        // Get config parameters
        $dbInfo['database_target'] = $this->getContainer()->getParameter('database_host');
        $dbInfo['database_name'] = $this->getContainer()->getParameter('drupal_database_name');
        $dbInfo['username'] = $this->getContainer()->getParameter('database_user');
        $dbInfo['password'] = $this->getContainer()->getParameter('database_password');

        // Build db connect
        $dbConnString = "mysql:host=" . $dbInfo['database_target'] . "; dbname=" . $dbInfo['database_name'];

        $this->dbh = new \PDO($dbConnString, $dbInfo['username'], $dbInfo['password']);
        $this->dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $this->output->writeln('<info>DATABASE CONNECTION SUCCESS</info>');

    }

}