<?php

namespace Aml\Bundle\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Aml\Bundle\BlogBundle\Entity\Article;
use Symfony\Component\HttpFoundation\Request;

/**
 * Blog controller.
 *
 * @Route("/blog")
 */
class BlogController extends Controller
{
    protected $_limitPagination = 5;

    /**
     * Lists all Blog entities.
     *
     * @Route("/{page}", name="blog",requirements={"page" = "\d+"}, defaults={"page" = 1})
     * @Template()
     */
    public function indexAction(Request $request, $page)
    {
        $filters = $categories = $tags = array();

        $category = $request->get('category');
        if ($category) {
            $filters['category'] = $category;
        }

        $tag = $request->get('tag');
        if ($tag) {
            $filters['tag'] = $tag;
        }


        $em = $this->getDoctrine()->getManager();
        $repositoryArticle = $this->getDoctrine()->getRepository('AmlBlogBundle:Article');

        // Get Nb articles
        $nbEntities = $repositoryArticle->countPublicArticles($filters);

        $num_pages = $page; // some calculation of what page you're currently on
        $entitiesBlog = $repositoryArticle->getPublicArticles(
            $this->_limitPagination,
            $this->_limitPagination * ($num_pages - 1),
            $filters
        );

        //var_dump( $entitiesBlog );exit;

        // Get Liste catégories
        // @TODO : charger que les catégories avec les articles liés
        $categories = $em->getRepository('AmlBlogBundle:Category')->findAll();

        // Get Liste tags
        $tags = $em->getRepository('AmlBlogBundle:Tags')->findAll();

        // Calcul de la pagination
        $calculLastPage = round($nbEntities / $this->_limitPagination);
        $pagination = array(
            'nbEntities' => $nbEntities,
            'limit' => $this->_limitPagination,
            'currentPage' => $page,
            'nextPage' => ($page + 1 * $this->_limitPagination < $nbEntities ? $page + 1 : false),
            'prevPage' => ($page - 1 > 0 ? $page - 1 : false),
            'lastPage' => ($calculLastPage >= 0 ? $calculLastPage : 0)
        );

        return array(
            'entities' => $entitiesBlog,
            'pagination' => $pagination,
            'categories' => $categories,
            'tags' => $tags
        );
    }

    /**
     * Finds and displays a Blog entity.
     *
     * @Route("/id/{id}", name="blog_show")
     * @Route("/article/{url_key}.html", name="blog_show_rewrite")
     * @Template()
     */
    public function showAction($id = false, $url_key = null)
    {
        $em = $this->getDoctrine()->getManager();

        if (false === $id) {
            $entity = $em->getRepository('AmlBlogBundle:Article')->getArticleByUrlKey($url_key);
        } else {
            $entity = $em->getRepository('AmlBlogBundle:Article')->find($id);
        }

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AmlBlogBundle:Blog entity.');
        }

        // Get Liste catégories
        // @TODO : charger que les catégories avec les articles liés
        $categories = $em->getRepository('AmlBlogBundle:Category')->findAll();

        // Get Liste tags
        $tags = $em->getRepository('AmlBlogBundle:Tags')->findAll();

        return array(
            'entity' => $entity,
            'categories' => $categories,
            'tags' => $tags
        );
    }


}
