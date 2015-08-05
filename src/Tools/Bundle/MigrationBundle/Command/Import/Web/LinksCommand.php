<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tools\Bundle\MigrationBundle\Command\Import\Web;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Aml\Bundle\WebBundle\Entity\Link;
use Tools\Bundle\MigrationBundle\Command\Import\AbstractCommand;


/**
 * Import Links from aml87.fr
 *
 * @author Aurélien GIRY <aurelien.giry@gmail.com>
 */
class LinksCommand extends AbstractCommand
{
    protected $_oldData = array();

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('migration:import:links')
            ->setDescription('Import links from old website')
            ->setHelp(<<<EOF
The <info>migration:import:links</info> command imports blog contents from website aml87.fr and debug mode:

<info>php app/console migration:import:links --debug</info>
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

    protected function _loadData()
    {
        $this->output->writeln('<info>Load links</info>');

        $queryString = "SELECT * FROM links";
        $query = $this->dbh->query($queryString);

        $this->_oldData = $query->fetchAll();
    }

    protected function _importContent()
    {
        $this->output->writeln('<info>Import Links: </info>');

        $em = $this->getContainer()->get('doctrine')->getManager('default');

        if (!empty($this->_oldData)) {
            foreach ($this->_oldData as $item) {
                $entity = new Link();

                $entity
                    ->setPublic($item['status'])
                    ->setTitle(utf8_encode($item['title']))
                    ->setUrl(utf8_encode($item['url']))
                    ->setDescription(utf8_encode($item['description']))
                    ->setWeight($item['weight']);

                $em->persist($entity);

                $this->output->writeln('<info>-' . utf8_decode($entity->getTitle()) . ' (URL: ' . utf8_decode($entity->getUrl()) . ')</info>');

            }
            $em->flush();
        }
    }

}