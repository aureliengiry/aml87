<?php

namespace Aml\Bundle\BlogBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * BlogRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BlogRepository extends EntityRepository
{

    /**
     * Function to build request in order to filter blog articles
     *
     * @param $query
     * @param array $params
     * @param array $filters
     * @return mixed
     */
    private function _buildRequestByFilters( $query, $params = array(), $filters = array() ){
        if( isset($filters['category']) && !empty($filters['category']) ){
            $query
                ->innerJoin('b.category', 'c')
                ->andWhere("c.system_name LIKE :category")
            ;
            $params['category'] = $filters['category'];
        }

        if( isset($filters['tag']) && !empty($filters['tag']) ){
            $query
                ->innerJoin('b.tags', 't')
                ->andWhere("t.system_name LIKE :tag")
            ;
            $params['tag'] = '%' . $filters['tag'] . '%';
        }

        $query->setParameters( $params );

        return $query;
    }

    /**
     * Function to count public articles
     * @return mixed
     */
    public function countPublicArticles( $filters = array() ){
		$em = $this->getEntityManager();		
			$qb = $em->createQueryBuilder();
			
			$qb
				->select('COUNT(b.id)')
				->from('AmlBlogBundle:Blog', 'b')
				->where("b.public = 1")
			;

            if( !empty($filters) ){
                $qb = $this->_buildRequestByFilters( $qb,array(), $filters );
            }
			$query = $qb->getQuery();
			
			//echo $query->getSql(); var_dump($query->getParameters());exit;
			
			return $query->getSingleScalarResult();
	}

    /**
     * Function to load articles blog
     *
     * @param $limit
     * @param int $offset
     * @param array $filters
     * @return mixed
     */
    public function getPublicArticles($limit, $offset = 0, $filters = array() ){

        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $qb
            ->select('b')
            ->from('AmlBlogBundle:Blog', 'b')
            ->where("b.public = 1")
            ->orderBy('b.created', 'DESC')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
        ;

        if( !empty($filters) ){
            $qb = $this->_buildRequestByFilters( $qb,array(), $filters );
        }

        $query = $qb->getQuery();

       // echo $query->getSql();
        //var_dump($query->getParameters());

        return $query->getResult();
    }

    /**
     * Fonction qui permet de supprimer les mots clés libres d'une discussion pour les rajouter proprement
     * @param unknown_type $blog
     */
    public function cleanTags($blog)
    {
        $em = $this->getEntityManager();
        foreach ($blog->getTags() as $tag)
        {
            $blog->removeTag($tag);
        }
        $em->flush();
    }

}