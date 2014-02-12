<?php

namespace Aml\Bundle\BlogBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * TagsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TagsRepository extends EntityRepository
{

    /**
     * Function pour récupérer les mots clés pour l'autocomplétion
     * @param string $value
     * @return array
     */
    public function getTags($value)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('t')
            ->from('AmlBlogBundle:Tags', 't')
            ->where("t.name LIKE :tag")
            ->orderBy('t.name', 'ASC')
            ->setParameter('tag', $value . '%');

        $query = $qb->getQuery();
        $tags = $query->getResult();

        $json = array();
        foreach ($tags as $mot) {
            $json[] = array(
                'label' => $mot->getName(),
                'value' => $mot->getId()
            );
        }

        return $json;
    }

    /**
     * Funtion to load TumblrTab by name
     *
     * @param string $tag
     * @return boolean
     */
    public function loadOneTagByName($tag)
    {
        $query = $this->getEntityManager()
            ->createQuery('SELECT bt.id,bt.name FROM AmlBlogBundle:Tags bt WHERE bt.name LIKE :tag')
            ->setParameter('tag', $tag);

        try {
            $result = $query->getSingleResult();
            return $result;

        } catch (\Doctrine\ORM\NoResultException $e) {
            return false;
        }

    }
}