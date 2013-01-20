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

use Aml\Bundle\WebBundle\Entity\Evenement;


/**
 * Import Links from aml87.fr
 *
 * @author Aurélien GIRY <aurelien.giry@gmail.com>
 */
class ImportEvenementsCommand extends ContainerAwareCommand
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
            ->setName('aml:import:evenements')
//            ->setDefinition(array(
//                new InputOption('no-warmup', '', InputOption::VALUE_NONE, 'Do not warm up the cache'),
//            ))
            ->setDescription('Import evenements from old website')
            ->setHelp(<<<EOF
The <info>aml:import:evenements</info> command imports blog contents from website aml87.fr and debug mode:

<info>php app/console aml:import:evenements --debug</info>
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
		var_dump( $this->_oldData );
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
		
		$queryString = "SELECT n.nid, n.title as titre, n.status, cta.field_rdv_date_concert_value as dateStart, nr.body as body 
		FROM node n 
		INNER JOIN  node_revisions nr ON n.nid=nr.nid 
		INNER JOIN content_type_agenda cta ON n.nid=cta.nid
		WHERE n.type='agenda'";
		
		$query = $this->dbh->query($queryString);
		
		$this->_oldData = $query->fetchAll();
    }

    protected function _importContent(){
    	var_dump(__METHOD__);
    	$em = $this->getContainer()->get('doctrine')->getEntityManager('default');
    	
    	if( !empty($this->_oldData) ){
    		foreach ($this->_oldData as $item) {    			   		
		    	$entity = new Evenement();

		    	$dateStart = new \DateTime();
		    	$dateStart->setTimestamp($item['dateStart']);	
		    	
		        $entity
		            ->setPublic($item['status'])
		            ->setTitle($item['titre'])
		            ->setDescription( $item['body'] )
		            ->setDateStart( $dateStart )
		            ->setArchive(0)
		            ->setType('concert')
		         ;
		       	         
		         $em->persist($entity);
		         $em->flush();
    		}
    	}
    }
    
}