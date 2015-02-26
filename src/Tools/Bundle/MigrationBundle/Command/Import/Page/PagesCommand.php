<?php
namespace Tools\Bundle\MigrationBundle\Command\Import\Page;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\KernelInterface;

use Tools\Bundle\MigrationBundle\Command\Import\AbstractCommand;
use Aml\Bundle\WebBundle\Entity\Page;
use Aml\Bundle\UrlRewriteBundle\Entity\UrlPage;


class PagesCommand extends AbstractCommand
{
    const URL_MEDIAS_OLD_SITE = 'sites/default/files';
    const URL_MEDIAS_NEW_SITE = 'uploads/images';
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('migration:import:pages')
            ->setDescription('Import Page from old website')
            ->setHelp(<<<EOF
The <info>migration:import:pages</info> command imports content page from website aml87.fr and debug mode:

<info>php app/console migration:import:pages --debug</info>
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
        $this->output->writeln('<info>Load pages</info>');

        $queryString = "SELECT n.title, nr.body, n.created, n.changed, n.status
FROM node n
INNER JOIN node_revisions nr ON nr.nid = n.nid
where type='association';";
        $query = $this->dbh->query($queryString);

        $this->_oldData = $query->fetchAll();
    }

    /**
     * Import Content
     */
    protected function _importContent()
    {
        $this->output->writeln('<info>Import Pages :</info>');
        $em = $this->getContainer()->get('doctrine')->getManager('default');

        if (!empty($this->_oldData)) {
            foreach ($this->_oldData as $item) {
                $entity = new Page();

                $createdDate = new \DateTime();
                $createdDate->setTimestamp($item['created']);

                $changedDate = new \DateTime();
                $changedDate->setTimestamp($item['changed']);

                // Parse Body
                $body = str_replace(self::URL_MEDIAS_OLD_SITE,self::URL_MEDIAS_NEW_SITE,$item['body']);

                $entity
                    ->setCreated($createdDate)
                    ->setUpdated($changedDate)
                    ->setTitle(utf8_encode($item['title']))
                    ->setBody(utf8_encode($body))
                    ->setPublic($item['status'])
                ;

                // Set Url
                if (isset($item['title']) && !empty($item['title'])) {
                    $newEntityUrl = new UrlPage();
                    $newEntityUrl->setUrlKey(utf8_encode($item['title']));

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
            ->where('e INSTANCE OF AmlUrlRewriteBundle:UrlPage')
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
                    ->where('e INSTANCE OF AmlUrlRewriteBundle:UrlPage')
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

}