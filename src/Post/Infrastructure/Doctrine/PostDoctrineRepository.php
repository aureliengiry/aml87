<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Post\Infrastructure\Doctrine;

use App\Post\Domain\Model\Post;
use App\Post\Domain\PostsInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;

/**
 * PostDoctrineRepository.
 */
class PostDoctrineRepository 
    implements PostsInterface, ServiceEntityRepositoryInterface
{
    /** @var RegistryInterface */
    private $entityManager;

     /**
     * PostDoctrineRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        $this->entityManager = $registry->getEntityManager();
    }

    /**
     * Function to build request in order to filter blog articles.
     *
     * @param $query
     *
     * @return array
     */
    private function buildRequestByFilters(QueryBuilder $query, array $params = [], array $filters = [])
    {
        if (isset($filters['category']) && !empty($filters['category'])) {
            $query
                ->innerJoin('a.category', 'c')
                ->andWhere('c.systemName LIKE :category');
            $params['category'] = $filters['category'];
        }

        if (isset($filters['tag']) && !empty($filters['tag'])) {
            $query
                ->innerJoin('a.tags', 't')
                ->andWhere('t.systemName LIKE :tag');
            $params['tag'] = '%'.$filters['tag'].'%';
        }

        $query->setParameters($params);

        return $query;
    }

    /**
     * Retrieves public articles.
     */
    public function getPublicArticles(int $page = 1, array $filters = [], int $limit = 5): Paginator
    {
        $qb = $this->entityManager->createQueryBuilder();

        $firstResult = ($page - 1) * $limit;
        $qb
            ->select('a')
            ->from(Post::class, 'a')
            ->where('a.public = 1')
            ->orderBy('a.createdAt', 'DESC');

        if (!empty($filters)) {
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
    public function cleanTags(Post $article)
    {
        foreach ($article->getTags() as $tag) {
            $article->removeTag($tag);
        }
        $$this->entityManager->flush();
    }

    /**
     * Find article by url key.
     *
     * @param $urlKey
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @return mixed|null
     */
    public function getArticleByUrlKey($urlKey)
    {
        $q = $this->entityManager->createQueryBuilder();
        $q
            ->select('p')
            ->from(Post::class, 'p')
            ->where('p.slug = :url_key')
            ->setMaxResults(1);

        $params = [
            'url_key' => $urlKey,
        ];

        $q->setParameters($params);

        return $q->getQuery()->getOneOrNullResult();
    }

    public function findLastPublicPost(){
        $q = $this->entityManager->createQueryBuilder();
        $q
            ->select('p')
            ->from(Post::class, 'p')
            ->where('p.public = :public_post')
            ->orderBy('p.createdAt')
            ->setMaxResults(1);

        $params = [
            'public_post' => Post::ARTICLE_IS_PUBLIC,
        ];

        $q->setParameters($params);

        return $q->getQuery()->getOneOrNullResult();
    }
}
