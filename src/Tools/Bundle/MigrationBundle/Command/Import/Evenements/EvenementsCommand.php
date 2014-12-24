<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tools\Bundle\MigrationBundle\Command\Import\Evenements;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\KernelInterface;

use Tools\Bundle\MigrationBundle\Command\Import\AbstractCommand;
use Aml\Bundle\EvenementsBundle\Entity\Evenement;

/**
 * Class EvenementsCommand
 * @package Tools\Bundle\MigrationBundle\Command\Import\Evenements
 */
class EvenementsCommand extends AbstractCommand
{
    protected $name;
    protected $_oldData = array();

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('migration:import:evenements')
            ->setDescription('Import evenements from old website')
            ->setHelp(<<<EOF
The <info>migration:import:evenements</info> command imports blog contents from website aml87.fr and debug mode:

<info>php app/console migration:import:evenements --debug</info>
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

        $this->output->writeln('<info>Load evenements</info>');

        $queryString = "SELECT n.nid, n.title as titre, n.status, cta.field_rdv_date_concert_value as dateStart, nr.body as body
		FROM node n 
		INNER JOIN  node_revisions nr ON n.nid=nr.nid 
		INNER JOIN content_type_agenda cta ON n.nid=cta.nid
		WHERE n.type='agenda'";

        $query = $this->dbh->query($queryString);

        $this->_oldData = $query->fetchAll();
    }

    /**
     * Import Content
     */
    protected function _importContent()
    {

        $this->output->writeln('<info>Import evenements :</info>');

        $em = $this->getContainer()->get('doctrine')->getManager('default');

        if (!empty($this->_oldData)) {
            foreach ($this->_oldData as $item) {
                $entity = new Evenement();

                $dateStart = new \DateTime();
                $dateStart->setTimestamp($item['dateStart']);

                $entity
                    ->setPublic($item['status'])
                    ->setTitle(utf8_encode($item['titre']))
                    ->setDescription(utf8_encode($item['body']))
                    ->setDateStart($dateStart)
                    ->setArchive(0)
                    ->setType('concert');

                $em->persist($entity);

                $this->output->writeln('<info>-' . utf8_decode($entity->getTitle()) . '</info>');

            }

            $em->flush();
        }
    }

}