<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * Function to build request in order to filter blog articles.
     *
     * @return array
     */
    private function buildRequestByFilters(\Doctrine\ORM\QueryBuilder $query, array $params = [], array $filters = []): \Doctrine\ORM\QueryBuilder
    {
        if (isset($filters['category']) && ! empty($filters['category'])) {
            $query
                ->innerJoin('a.category', 'c')
                ->andWhere('c.systemName LIKE :category');
            $params['category'] = $filters['category'];
        }

        if (isset($filters['tag']) && ! empty($filters['tag'])) {
            $query
                ->innerJoin('a.tags', 't')
                ->andWhere('t.systemName LIKE :tag');
            $params['tag'] = '%'.$filters['tag'].'%';
        }

        $query->setParameters($params);

        return $query;
    }

    public function getPublicArticles(int $page = 1, array $filters = [], int $limit = 5): Paginator
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $firstResult = ($page - 1) * $limit;
        $qb
            ->select('a')
            ->from(Article::class, 'a')
            ->leftJoin('a.logo', 'm')
            ->leftJoin('a.url', 'u')
            ->where('a.public = 1')
            ->orderBy('a.created', 'DESC');

        if ([] !== $filters) {
            $qb = $this->buildRequestByFilters($qb, [], $filters);
        }

        $qb
            ->setFirstResult($firstResult)
            ->setMaxResults($limit);

        return new Paginator($qb->getQuery());
    }

    /**
     * Fonction qui permet de supprimer les mots clés d'un article de blog.
     */
    public function cleanTags(Article $article): void
    {
        $em = $this->getEntityManager();
        foreach ($article->getTags() as $tag) {
            $article->removeTag($tag);
        }

        $em->flush();
    }

    /**
     * Find article by url key.
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @return mixed|null
     */
    public function getArticleByUrlKey($urlKey)
    {
        $q = $this->getEntityManager()->createQueryBuilder();
        $q
            ->select('e')
            ->from(Article::class, 'e')
            ->join('e.url', 'u')
            ->where('u.urlKey = :url_key')
            ->setMaxResults(1);

        $params = [
            'url_key' => $urlKey,
        ];

        $q->setParameters($params);

        return $q->getQuery()->getOneOrNullResult();
    }
}
