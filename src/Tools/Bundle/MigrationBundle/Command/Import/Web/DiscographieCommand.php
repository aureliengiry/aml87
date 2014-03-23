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
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\KernelInterface;

use Aml\Bundle\WebBundle\Entity\Album;
use Tools\Bundle\MigrationBundle\Command\Import\AbstractCommand;

/**
 * Class DiscographieCommand
 *
 * Import Discographie from aml87.fr
 *
 * @package Tools\Bundle\MigrationBundle\Command\Import\Web
 */
class DiscographieCommand extends AbstractCommand
{
    protected $_oldDiscs = array();

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('migration:import:discographie')
            ->setDescription('Import dicographie from old website')
            ->setHelp(<<<EOF
The <info>migration:import:discographie</info> command imports blog contents from website aml87.fr and debug mode:

<info>php app/console migration:import:discographie --debug</info>
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
     * Load tags
     */
    protected function _loadData()
    {
        $this->output->writeln('<info>Load discographie</info>');

        $queryString = "SELECT n.nid, n.title as titre, n.status, ctd.field_disco_date_sortie_value as date, nr.body as body,
        (SELECT f.filename FROM files f WHERE f.fid=ctd.field_disco_pochette_fid ) as filename
		FROM node n 
		INNER JOIN node_revisions nr ON n.nid=nr.nid
		INNER JOIN content_type_discographie ctd ON n.nid=ctd.nid
		WHERE n.type='discographie'";
        $query = $this->dbh->query($queryString);

        $this->_oldDiscs = $query->fetchAll();
    }

    /**
     * Import Content
     */
    protected function _importContent()
    {
        $this->output->writeln('<info>Import Discographie</info>');

        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');

        if (!empty($this->_oldDiscs)) {
            foreach ($this->_oldDiscs as $album) {
                $entityDiscographie = new Album();

                $sortieDate = new \DateTime();
                $sortieDate->setTimestamp($album['date']);

                $entityDiscographie
                    ->setPublic($album['status'])
                    ->setTitle(utf8_encode($album['titre']))
                    ->setDescription(utf8_encode($album['body']))
                    ->setDate($sortieDate)
                ;

                // Set Image
                if (isset($album['filename']) && !empty($album['filename'])) {
                    $entityAlbumImage = $em->getRepository('AmlMediasBundle:Image')->findOneBy(
                        array('path' => utf8_encode($album['filename']))
                    );

                    if ($entityAlbumImage) {
                        $entityDiscographie->setImage($entityAlbumImage);
                    }
                }

                $em->persist($entityDiscographie);

                $this->output->writeln('<info>-' . utf8_decode($entityDiscographie->getTitle()) . '</info>');
            }

            $em->flush();
        }
    }

}