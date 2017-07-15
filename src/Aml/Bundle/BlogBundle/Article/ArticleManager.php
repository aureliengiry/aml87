<?php
namespace Aml\Bundle\BlogBundle\Article;


use Aml\Bundle\BlogBundle\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;

class ArticleManager
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getPublicArticlesWithPagination(int $page, array $filter)
    {
        return $this->getArticleRepository()->getPublicArticles($page, $filter);
    }

    public function getArticleByIdOrUrl($urlKey)
    {
        if (is_int($urlKey)) {
            return $this->getArticleRepository()->find($urlKey);
        } else {
            return $this->getArticleRepository()->getArticleByUrlKey($urlKey);
        }
    }

    private function getArticleRepository()
    {
        return $this->em->getRepository(Article::class);
    }
}
