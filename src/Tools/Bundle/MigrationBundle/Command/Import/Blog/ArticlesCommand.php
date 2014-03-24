<?php
/**
 * Import Blog contens from aml87.fr
 *
 * @author Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace Tools\Bundle\MigrationBundle\Command\Import\Blog;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\KernelInterface;

use Tools\Bundle\MigrationBundle\Command\Import\AbstractCommand;
use Aml\Bundle\BlogBundle\Entity\Article;

/**
 * Class ArticlesCommand
 * @package Tools\Bundle\MigrationBundle\Command\Import\Blog
 */
class ArticlesCommand extends AbstractCommand
{
    protected $name;
    protected $_oldArticles = array();

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('migration:import:blog-articles')
            ->setDescription('Import Blog articles from old website')
            ->setHelp(<<<EOF
The <info>migration:import:blog-articles</info> command imports blog contents from website aml87.fr and debug mode:

<info>php app/console migration:import:blog-articles --debug</info>
EOF
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->_loadBlogArticles();

        $this->_importContent();
    }

    /**
     * Load articles
     */
    protected function _loadBlogArticles()
    {
        $this->output->writeln('<info>Load articles of blog</info>');

        $queryString = "SELECT n.nid AS nodeId, n.title as titre, n.status, n.created, n.changed, nr.body as body,
		(SELECT td.name FROM term_node tn INNER JOIN term_data td ON tn.tid=td.tid WHERE tn.nid = nodeId AND td.vid=2) AS category,
		(SELECT f.filename FROM files f WHERE f.fid=cta.field_blog_article_img_fid ) as filename,
		cta.field_video_value as videoId
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
        $this->output->writeln('<info>Get Tags of article:' . $idArticle . '</info>');
        $queryString = "SELECT td.name FROM term_node tn INNER JOIN term_data td ON tn.tid=td.tid WHERE tn.nid = $idArticle AND td.vid=3";
        $query = $this->dbh->query($queryString);

        return $query->fetchAll();
    }

    /**
     * Import Content
     */
    protected function _importContent()
    {
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
                $buildCategoryName = $this->_build_category_name(utf8_encode($article['category']));
                $entityBlogCategorie = $em->getRepository('AmlBlogBundle:Category')->findOneBy(
                    array('system_name' => $buildCategoryName)
                );
                $entityArticle->setCategory($entityBlogCategorie);

                // Set Tags
                $associatedTags = $this->_getArticleTags($article['nodeId']);
                foreach ($associatedTags as $tag) {
                    $tagName = $this->_build_category_name(utf8_encode($tag['name']));
                    $entityBlogTags = $em->getRepository('AmlBlogBundle:Tags')->findOneBy(
                        array('system_name' => $tagName)
                    );
                    $entityArticle->addTag($entityBlogTags);
                }

                // Set Image
                if (isset($article['filename']) && !empty($article['filename'])) {
                    $entityBlogImage = $em->getRepository('AmlMediasBundle:Image')->findOneBy(
                        array('path' => utf8_encode($article['filename']))
                    );

                    if ($entityBlogImage) {
                        $entityArticle->setLogo($entityBlogImage);
                    }
                }

                // Set Video
                if (isset($article['videoId']) && !empty($article['videoId'])) {
                    $entityBlogVideo= $em->getRepository('AmlMediasBundle:Video')->findOneBy(
                        array('providerId' => utf8_encode($article['videoId']))
                    );

                    if ($entityBlogVideo) {
                        $entityArticle->setVideo($entityBlogVideo);
                    }
                }

                $em->persist($entityArticle);

                $this->output->writeln('<info>-' . utf8_decode($entityArticle->getTitle()) . '</info>');

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