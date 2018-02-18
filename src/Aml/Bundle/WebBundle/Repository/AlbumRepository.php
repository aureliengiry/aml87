<?php

namespace Aml\Bundle\WebBundle\Repository;

use Aml\Bundle\WebBundle\Entity\Album;
use Doctrine\ORM\EntityRepository;

/**
 * AlbumRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AlbumRepository extends EntityRepository
{
    public function getAlbumByUrlKey($urlKey)
    {
        $q = $this->getEntityManager()->createQueryBuilder();
        $q
            ->select('e')
            ->from(Album::class, 'e')
            ->join('e.url', 'u')
            ->where('u.urlKey = :url_key')
            ->setMaxResults(1);

        $params = ['url_key' => $urlKey];

        $q->setParameters($params);

        return $q->getQuery()->getOneOrNullResult();

    }
}
