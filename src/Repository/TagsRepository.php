<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Tags;
use Doctrine\ORM\EntityRepository;

/**
 * TagsRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TagsRepository extends EntityRepository
{
    /**
     * Function pour récupérer les mots clés pour l'autocomplétion.
     *
     * @param string $value
     *
     * @return array
     */
    public function getTags($value)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('t')
            ->from(Tags::class, 't')
            ->where('t.name LIKE :tag')
            ->orderBy('t.name', 'ASC')
            ->setParameter('tag', $value.'%');

        $query = $qb->getQuery();
        $tags = $query->getResult();

        $json = [];
        foreach ($tags as $mot) {
            $json[] = [
                'label' => $mot->getName(),
                'value' => $mot->getId(),
            ];
        }

        return $json;
    }

    /**
     * Funtion to load TumblrTab by name.
     *
     * @param string $tag
     *
     * @return bool
     */
    public function loadOneTagByName($tag)
    {
        $query = $this->getEntityManager()
            ->createQuery('SELECT bt.id,bt.name FROM Tags::class bt WHERE bt.name LIKE :tag')
            ->setParameter('tag', $tag);

        try {
            return $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return false;
        }
    }

    /**
     * Function retrieves all tags with nb articles by tag.
     *
     * @return array
     */
    public function getTagsWithNbArticles()
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb
            ->select('t.systemName', 't.name', 'count(a.id) as nbArticles')
            ->from(Tags::class, 't')
            ->join('t.articles', 'a')
            ->where('a.public = :public')
            ->groupBy('t.id')
            ->orderBy('t.name', 'ASC')
        ;

        $qb->setParameter('public', Article::ARTICLE_IS_PUBLIC);

        return $qb->getQuery()->getResult();
    }
}
