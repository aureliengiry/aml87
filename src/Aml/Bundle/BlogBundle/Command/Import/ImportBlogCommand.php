<?php
/**
 * Import Blog contens from aml87.fr
 *
 * @author Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace Aml\Bundle\BlogBundle\Command\Import;

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
            ->setName('blog:import:articles')
            ->setDescription('Import Blog contents from old website')
            ->setHelp(<<<EOF
The <info>blog:import:articles</info> command imports blog contents from website aml87.fr and debug mode:

<info>php app/console blog:import:articles --debug</info>
EOF
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        var_dump(__METHOD__);
        $this->_loadBlogArticles();
        var_dump($this->_oldArticles);
        $this->_importContent();
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
    protected function _loadBlogArticles()
    {
        var_dump(__METHOD__);

        $this->_connectDb();

        $queryString = "SELECT n.nid AS nodeId, n.title as titre, n.status, n.created, n.changed, nr.body as body,
		(SELECT td.name FROM term_node tn INNER JOIN term_data td ON tn.tid=td.tid WHERE tn.nid = nodeId AND td.vid=2) AS category,
		(SELECT f.filename FROM files f WHERE f.fid=cta.field_blog_article_img_fid ) as filename
		FROM node n 
		INNER JOIN node_revisions nr ON n.nid=nr.nid
		INNER JOIN content_type_article cta ON n.nid=cta.nid
		WHERE n.type='article'";
        $query = $this->dbh->query($queryString);

        $this->_oldArticles = $query->fetchAll();
    }

    /**
     * Load Tags of each articles
     *
     * @param $idArticle
     * @return mixed
     */
    protected function _getArticleTags($idArticle)
    {
        $this->_connectDb();

        $queryString = "SELECT td.name FROM term_node tn INNER JOIN term_data td ON tn.tid=td.tid WHERE tn.nid = $idArticle AND td.vid=3";
        $query = $this->dbh->query($queryString);

        return $query->fetchAll();
    }

    /**
     * Import Content
     */
    protected function _importContent()
    {
        var_dump(__METHOD__);
        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');

        if (!empty($this->_oldArticles)) {
            foreach ($this->_oldArticles as $article) {

                $entityArticle = new Article();

                $createdDate = new \DateTime();
                $createdDate->setTimestamp($article['created']);

                $changedDate = new \DateTime();
                $changedDate->setTimestamp($article['changed']);

                $entityArticle
                    ->setCreated($createdDate)
                    ->setUpdated($changedDate)
                    ->setPublic($article['status'])
                    ->setTitle(utf8_encode($article['titre']))
                    ->setBody($article['body']);

                if (isset($article['status']) && $article['status'] == 1) {
                    $entityArticle->setPublished($changedDate);
                }

                // Set category
                $buildCategoryName = $this->_build_category_name($article['category']);
                $entityBlogCategorie = $em->getRepository('AmlBlogBundle:Category')->findOneBy(array('system_name' => $buildCategoryName));
                $entityArticle->setCategory($entityBlogCategorie);

                // Set Tags
                $associatedTags = $this->_getArticleTags($article['nodeId']);
                foreach ($associatedTags as $tag) {
                    $tagName = $this->_build_category_name($tag['name']);
                    $entityBlogTags = $em->getRepository('AmlBlogBundle:Tags')->findOneBy(array('system_name' => $tagName));
                    $entityArticle->addTag($entityBlogTags);
                }

                // Set Image
                if( isset($article['filename']) && !empty($article['filename']) )
                {
                    $entityBlogImage = $em->getRepository('AmlMediasBundle:Image')->findOneBy(array('path' => utf8_encode(())$article['filename']));
                    if( $entityBlogImage ){
                        $entityArticle->setLogo($entityBlogImage);
                    }
                }

                $em->persist($entityArticle);

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