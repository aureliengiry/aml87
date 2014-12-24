<?php
/**
 * Import Blog contents from aml87.fr
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
use Aml\Bundle\BlogBundle\Entity\Category;

/**
 * Class CategoriesCommand
 * @package Tools\Bundle\MigrationBundle\Command\Import\Blog
 */
class CategoriesCommand extends AbstractCommand
{
    protected $name;
    protected $_oldData = array();

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('migration:import:blog-categories')
            ->setDescription('Import Blog Categories from old website')
            ->setHelp(<<<EOF
The <info>migration:import:blog-categories</info> command imports blog categories from website aml87.fr and debug mode:

<info>php app/console migration:import:blog-categories --debug</info>
EOF
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Load data
        $this->_loadData();

        // Insert data to current DB
        $this->_importContent();
    }

    /**
     *  Load categories
     */
    protected function _loadData()
    {
        $this->output->writeln('<info>Load categories of blog</info>');

        // import vocabulary 2 ( Blog )
        $queryString = "SELECT *
		FROM term_data 		
		WHERE vid=2";
        $query = $this->dbh->query($queryString);

        $this->_oldData = $query->fetchAll();
    }

    /**
     * Import Content
     */
    protected function _importContent()
    {
        $this->output->writeln('<info>Import Categories :</info>');
        $em = $this->getContainer()->get('doctrine')->getManager('default');

        if (!empty($this->_oldData)) {
            foreach ($this->_oldData as $item) {
                $entity = new Category();
                $entity
                    ->setName(utf8_encode($item['name']))
                    ->setSystemName(utf8_encode($item['name']))
                    ->setDescription(utf8_encode($item['description']));

                $em->persist($entity);

                $this->output->writeln('<info>-' . utf8_decode($entity->getName()) . ' (' . $entity->getSystemName() . ')</info>');
            }

            $em->flush();
        }
    }

}