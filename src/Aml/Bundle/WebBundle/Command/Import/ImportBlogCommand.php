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

use Aml\Bundle\BlogBundle\Entity\Blog;


/**
 * Import Blog contens from aml87.fr
 *
 * @author Aurélien GIRY <aurelien.giry@gmail.com>
 */
class ImportBlogCommand extends ContainerAwareCommand
{
    protected $name;
    protected $dbh;
    protected $_oldArticles = array();

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('aml:import:blog')
//            ->setDefinition(array(
//                new InputOption('no-warmup', '', InputOption::VALUE_NONE, 'Do not warm up the cache'),
//            ))
            ->setDescription('Import Blog contents from old website')
            ->setHelp(<<<EOF
The <info>aml:import:blog</info> command imports blog contents from website aml87.fr and debug mode:

<info>php app/console cache:clear --debug</info>
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
    	$this->_loadBlogArticles();
		var_dump( $this->_oldArticles );
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
    
    
    protected function _loadBlogArticles() {
    	
    	var_dump(__METHOD__);
    	
    	$this->_connectDb();
		
		$queryString = "SELECT n.nid AS nodeId, n.title as titre, n.status, n.created, n.changed, nr.body as body,
		(SELECT td.name FROM term_node tn INNER JOIN term_data td ON tn.tid=td.tid WHERE tn.nid = nodeId AND td.vid=2) AS category
		FROM node n 
		INNER JOIN  node_revisions nr ON n.nid=nr.nid 		
		WHERE n.type='article'";
		$query = $this->dbh->query($queryString);
		
		$this->_oldArticles = $query->fetchAll();
    }
    
    protected function _getArticleTags( $idArticle ){
    	$this->_connectDb();
		
		$queryString = "SELECT td.name FROM term_node tn INNER JOIN term_data td ON tn.tid=td.tid WHERE tn.nid = $idArticle AND td.vid=3";
		$query = $this->dbh->query($queryString);
		
		return $query->fetchAll();
    }

    protected function _importContent(){
    	var_dump(__METHOD__);
    	$em = $this->getContainer()->get('doctrine')->getEntityManager('default');
    	
    	if( !empty($this->_oldArticles) ){
    		foreach ($this->_oldArticles as $article) {      			
		    	$entityBlog = new Blog();
		    	
		    	$createdDate = new \DateTime();
		    	$createdDate->setTimestamp($article['created']);
		    	
		    	$changedDate = new \DateTime();
		    	$changedDate->setTimestamp($article['changed']);

		    		    	
		        $entityBlog
		        	->setCreated($createdDate)
		            ->setUpdated($changedDate)
		            ->setPublic($article['status'])
		            ->setTitle($article['titre'])
		            ->setBody($article['body'])		            
		         ;
		         
		         if( isset($article['status']) && $article['status'] == 1 ){
		         	    $entityBlog->setPublished($changedDate);
		         }
		         
		         
		         // Set category
		         $buildCategoryName = $this->_build_category_name( $article['category'] );		         
    			 $entityBlogCategorie = $em->getRepository('AmlBlogBundle:BlogCategories')->findOneBy(array('system_name' => $buildCategoryName ));
		         $entityBlog->setCategory($entityBlogCategorie);
    			 
		         // Set Tags
		         $associatedTags = $this->_getArticleTags( $article['nodeId'] );
		         var_dump( $associatedTags );
		         $associatedTagsName = array();
		         foreach( $associatedTags as $tag ){
		         	$tagName = $this->_build_category_name( $tag['name'] );
		         	$entityBlogTags = $em->getRepository('AmlBlogBundle:BlogTags')->findOneBy(array('system_name' => $tagName ));
		         	$entityBlog->addTags($entityBlogTags);
		         }
		         		         
		         
		        // var_dump( $associatedTags,$associatedTagsName,$entityBlogTags );exit;
		        			
		         
		         
		         $em->persist($entityBlog);
		         $em->flush();
    		}
    	}
    }
    
    /**
     * http://www.ficgs.com/How-to-remove-accents-in-PHP-f3057.html
     */
    protected function _build_category_name($string)
    {
    	
        $string = str_replace( array('à','á','â','ã','ä', 'ç', 'è','é','ê','ë', 'ì','í','î','ï', 'ñ', 'ò','ó','ô','õ','ö', 'ù','ú','û','ü', 'ý','ÿ', 'À','Á','Â','Ã','Ä', 'Ç', 'È','É','Ê','Ë', 'Ì','Í','Î','Ï', 'Ñ', 'Ò','Ó','Ô','Õ','Ö', 'Ù','Ú','Û','Ü', 'Ý'), array('a','a','a','a','a', 'c', 'e','e','e','e', 'i','i','i','i', 'n', 'o','o','o','o','o', 'u','u','u','u', 'y','y', 'A','A','A','A','A', 'C', 'E','E','E','E', 'I','I','I','I', 'N', 'O','O','O','O','O', 'U','U','U','U', 'Y'), $string);
    	$string = str_replace(array(' ','-'), array('_','_'),$string);
        
    	return strtolower($string);
    } 
    
}