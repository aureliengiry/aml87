<?php

namespace Aml\Bundle\BlogBundle\Repository;

use Aml\Bundle\BlogBundle\Entity\Article;
use Aml\Bundle\BlogBundle\Entity\Category;
use Doctrine\ORM\EntityRepository;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends EntityRepository
{
    /**
     * Function retrieves all categories with nb articles by category
     *
     * @param string $value
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
