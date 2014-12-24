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

use Tools\Bundle\MigrationBundle\Command\Import\AbstractCommand;
use Aml\Bundle\BlogBundle\Entity\Tags;

/**
 * Class TagsCommand
 * @package Tools\Bundle\MigrationBundle\Command\Import\Blog
 */
class TagsCommand extends AbstractCommand
{
    protected $name;
    protected $_oldData = array();

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('migration:import:blog-tags')
            ->setDescription('Import Blog tags from old website')
            ->setHelp(<<<EOF
The <info>migration:import:blog-tags</info> command imports blog categories from website aml87.fr and debug mode:

<info>php app/console migration:import:blog-tags --debug</info>
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
     *  Load tags
     */
    protected function _loadData()
    {
        $this->output->writeln('<info>Load tags of blog</info>');

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
        $this->output->writeln('<info>Import tags :</info>');
        $em = $this->getContainer()->get('doctrine')->getManager('default');

        if (!empty($this->_oldData)) {
            foreach ($this->_oldData as $item) {
                $entity = new Tags();
                $entity
                    ->setName(utf8_encode($item['name']))
                    ->setSystemName(utf8_encode($item['name']))
                    ->setWeight($item['weight'])
                    ->setDescription(utf8_encode($item['description']));

                $em->persist($entity);

                $this->output->writeln('<info>-' . utf8_decode($entity->getName()) . ' (' . $entity->getSystemName() . ')</info>');
            }

            $em->flush();
        }
    }

}