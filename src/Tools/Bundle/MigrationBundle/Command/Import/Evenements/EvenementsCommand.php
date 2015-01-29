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

use Aml\Bundle\UrlRewriteBundle\Entity\UrlEvenement;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\KernelInterface;

use Tools\Bundle\MigrationBundle\Command\Import\AbstractCommand;
use Aml\Bundle\EvenementsBundle\Entity\Evenement;
use Aml\Bundle\UrlRewriteBundle\Entity\Url;

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
     * Check if url key already exist and rename if needed
     *
     * @param $urlKey
     *
     * @return string
     */
    protected function _checkAndBuildUrlKey($urlKey)
    {
        $em = $this->getContainer()->get('doctrine')->getManager('default');

        $qb = $em->getRepository('AmlUrlRewriteBundle:Url')->createQueryBuilder('e');
        $qb->select('count(e.id)')
            ->where('e INSTANCE OF AmlUrlRewriteBundle:UrlEvenement')
            ->andWhere('e.urlKey like :url_key')
            ->setParameter('url_key', $urlKey);
        $nbUrl = $qb->getQuery()->getSingleScalarResult();

        if ($nbUrl > 0) {
            $i = (int)$nbUrl + 1;
            $urlAlreadyExist = true;
            while ($urlAlreadyExist === true) {
                $updatedUrlKey = $urlKey . '-' . $i;

                $qb = $em->getRepository('AmlUrlRewriteBundle:Url')->createQueryBuilder('e');
                $qb->select('count(e.id)')
                    ->where('e INSTANCE OF AmlUrlRewriteBundle:UrlEvenement')
                    ->andWhere('e.urlKey like :url_key')
                    ->setParameter('url_key', $updatedUrlKey);
                $findEntityUrl = $qb->getQuery()->getSingleScalarResult();

                if ($findEntityUrl == 0) {
                    $urlAlreadyExist = false;
                    return $updatedUrlKey;
                } else {
                    $i++;
                }
            }
        } else {
            return $urlKey;
        }
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

                // Set Url
                if (isset($item['titre']) && !empty($item['titre'])) {


                    $newEntityUrl = new UrlEvenement();
                    $newEntityUrl->setUrlKey(utf8_encode($item['titre']));

                    $urlKey = $newEntityUrl->getUrlKey();
                    $finalUrlKey = $this->_checkAndBuildUrlKey($urlKey);

                    $newEntityUrl->setUrlKey($finalUrlKey);

                    $entity->setUrl($newEntityUrl);
                }

                $em->persist($entity);

                $this->output->writeln('<info>-' . utf8_decode($entity->getTitle()) . '</info>');

            }

            $em->flush();
        }
    }

}