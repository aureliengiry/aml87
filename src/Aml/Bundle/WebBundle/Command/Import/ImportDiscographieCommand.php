<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aml\Bundle\WebBundle\Command\Import;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\KernelInterface;

use Aml\Bundle\WebBundle\Entity\Album;


/**
 * Import Discographie from aml87.fr
 *
 * @author Aurélien GIRY <aurelien.giry@gmail.com>
 */
class ImportDiscographieCommand extends ContainerAwareCommand
{
    protected $name;
    protected $dbh;
    protected $_oldDiscs = array();

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('aml:import:discographie')
//            ->setDefinition(array(
//                new InputOption('no-warmup', '', InputOption::VALUE_NONE, 'Do not warm up the cache'),
//            ))
            ->setDescription('Import dicographie from old website')
            ->setHelp(<<<EOF
The <info>aml:import:discographie</info> command imports blog contents from website aml87.fr and debug mode:

<info>php app/console aml:import:discographie --debug</info>
EOF
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
    	var_dump(__METHOD__);
    	$this->_loadData();
		var_dump( $this->_oldDiscs );
		$this->_importContent();
    }
    
 	protected function _connectDb(){
        $dbInfo['database_target'] = $this->getContainer()->getParameter('import_database_host');
		$dbInfo['database_name'] = $this->getContainer()->getParameter('import_database_name');
	  	$dbInfo['username'] = $this->getContainer()->getParameter('import_database_user');
	  	$dbInfo['password'] = $this->getContainer()->getParameter('import_database_password');
	
		$dbConnString = "mysql:host=" . $dbInfo['database_target'] . "; dbname=" . $dbInfo['database_name'];
		$this->dbh = new \PDO($dbConnString, $dbInfo['username'], $dbInfo['password']);
		$this->dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		$error = $this->dbh->errorInfo();
		if($error[0] != "") {
			print "<p>DATABASE CONNECTION ERROR:</p>";
		    print_r($error);
		}
    }
    
    protected function _loadData() {
    	
    	var_dump(__METHOD__);
    	
    	$this->_connectDb();
		
		$queryString = "SELECT n.nid, n.title as titre, n.status, ctd.field_disco_date_sortie_value as date, nr.body as body 
		FROM node n 
		INNER JOIN  node_revisions nr ON n.nid=nr.nid 
		INNER JOIN content_type_discographie ctd ON n.nid=ctd.nid
		WHERE n.type='discographie'";
		$query = $this->dbh->query($queryString);
		
		$this->_oldDiscs = $query->fetchAll();
    }

    protected function _importContent(){
    	var_dump(__METHOD__);
    	$em = $this->getContainer()->get('doctrine')->getEntityManager('default');
    	
    	if( !empty($this->_oldDiscs) ){
    		foreach ($this->_oldDiscs as $album) {    			   		
		    	$entityDiscographie = new Album();
		    	
		    	$sortieDate = new \DateTime();
		    	$sortieDate->setTimestamp($album['date']);		    

		    		    	
		        $entityDiscographie
		            ->setPublic($album['status'])
		            ->setTitle($album['titre'])
		            ->setDescription($album['body'])
		            ->setDate( $sortieDate )
		         ;
		       	         
		         $em->persist($entityDiscographie);
		         $em->flush();
    		}
    	}
    }
    
}