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

use Aml\Bundle\UrlRewriteBundle\Entity\UrlDiscography;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\KernelInterface;

use Aml\Bundle\DiscographyBundle\Entity\Album;
use Aml\Bundle\DiscographyBundle\Entity\Track;
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

        $em = $this->getContainer()->get('doctrine')->getManager('default');

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

                // Set Url
                if (isset($album['titre']) && !empty($album['titre'])) {
                    $newEntityUrl = new UrlDiscography();
                    $newEntityUrl->setUrlKey(utf8_encode($album['titre']));

                    $urlKey = $newEntityUrl->getUrlKey();

                    $finalUrlKey = $this->_checkAndBuildUrlKey($urlKey);
                    $newEntityUrl->setUrlKey($finalUrlKey);

                    $entityDiscographie->setUrl($newEntityUrl);
                }

                // Set tracks
                if (isset($album['nid']) && !empty($album['nid'])) {
                    $this->_getAlbumTracks($album,$entityDiscographie);
                }

                $em->persist($entityDiscographie);

                $this->output->writeln('<info>-' . utf8_decode($entityDiscographie->getTitle()) . '</info>');
            }

            $em->flush();
        }
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
            ->where('e INSTANCE OF AmlUrlRewriteBundle:UrlDiscography')
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
                    ->where('e INSTANCE OF AmlUrlRewriteBundle:UrlDiscography')
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

    protected function _getAlbumTracks($album,$entityDiscographie){

        $idAlbum = (int)$album['nid'];
        $this->output->writeln('<info>Load discographie tracks (nid:'.$idAlbum.')</info>');

        $em = $this->getContainer()->get('doctrine')->getManager('default');

        $queryString = "SELECT id_track, title, author
		FROM disc_tracks
		WHERE id_disc=$idAlbum";
        $query = $this->dbh->query($queryString);

        $albumTracks = $query->fetchAll();

        foreach( $albumTracks as $track ){
            $entityTrack = new Track();
            $entityTrack
                ->setNumber($track['id_track'])
                ->setAlbum($entityDiscographie)
                ->setTitle(utf8_encode($track['title']))
                ->setComposer(utf8_encode($track['author']))
            ;

            $entityDiscographie->addTrack($entityTrack);
        }
    }

}