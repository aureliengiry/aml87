<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Tags;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tags|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tags|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tags[]    findAll()
 * @method Tags[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tags::class);
    }

    /**
     * Function pour récupérer les mots clés pour l'autocomplétion.
     */
    public function getTags(string $value): array
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
     * Function to load TumblrTab by name.
     *
     * @return iterable|bool
     */
    public function loadOneTagByName(string $tag)
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
     */
    public function getTagsWithNbArticles(): iterable
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb
            ->select('t.systemName', 't.name', 'count(a.id) as nbArticles')
            ->from(Tags::class, 't')
            ->join('t.articles', 'a')
            ->where('a.public = :public')
            ->groupBy('t.id')
            ->orderBy('t.name', 'ASC');

        $qb->setParameter('public', Article::ARTICLE_IS_PUBLIC);

        return $qb->getQuery()->getResult();
    }
}
