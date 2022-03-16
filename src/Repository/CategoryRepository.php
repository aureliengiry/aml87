<?php

declare(strict_types=1);

/**
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>.
 */

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 *
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * Function retrieves all categories with nb articles by category.
     *
     * @return array
     */
    public function getCategoriesWithNbArticles()
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb
            ->select('c.systemName', 'c.name', 'count(a.id) as nbArticles', 'c.description')
            ->from(Article::class, 'a')
            ->innerJoin(Category::class, 'c', 'WITH', 'c.id=a.category')
            ->where('a.public = :public')
            ->groupBy('c.id')
            ->orderBy('c.name', 'ASC');

        $qb->setParameter('public', Article::ARTICLE_IS_PUBLIC);

        return $qb->getQuery()->getResult();
    }
}
