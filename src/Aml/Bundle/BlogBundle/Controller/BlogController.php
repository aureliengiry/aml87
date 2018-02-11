<?php
namespace Aml\Bundle\BlogBundle\Controller;

use Aml\Bundle\BlogBundle\Article\ArticleManager;
use Aml\Bundle\BlogBundle\Entity\Category;
use Aml\Bundle\BlogBundle\Entity\Tags;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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
     * @Template("blog/index.html.twig")
     * @Method("GET")
     */
    public function indexAction(Request $request, $page)
    {
        $filters = [];

        $category = $request->get('category');
        if ($category) {
            $filters['category'] = $category;
        }

        $tag = $request->get('tag');
        if ($tag) {
            $filters['tag'] = $tag;
        }

        $em = $this->getDoctrine()->getManager();

        $publicArticles = $this->get(ArticleManager::class)->getPublicArticlesWithPagination($page, $filters);
        $nbPublicArticles = count($publicArticles);

        // Calcul de la pagination
        $calculLastPage = round($nbPublicArticles / $this->_limitPagination);
        $pagination = [
            'nbEntities'  => $nbPublicArticles,
            'nbPages'     => ceil($nbPublicArticles / $this->_limitPagination),
            'limit'       => $this->_limitPagination,
            'currentPage' => $page,
            'nextPage'    => ($page + 1 * $this->_limitPagination < $nbPublicArticles ? $page + 1 : false),
            'prevPage'    => ($page - 1 > 0 ? $page - 1 : false),
            'lastPage'    => ($calculLastPage >= 0 ? $calculLastPage : 0),
        ];

        return [
            'entities'   => $publicArticles,
            'pagination' => $pagination,
            'categories' => $em->getRepository(Category::class)->getCategoriesWithNbArticles(),
            'tags'       => $this->get(ArticleManager::class)->getTagsWithNbArticles(),
        ];
    }

    /**
     * Finds and displays a Blog entity.
     *
     * @Route("/article/{slug}.html", name="blog_show")
     * @Template("blog/show.html.twig")
     * @Method("GET")
     */
    public function showAction($slug, Request $request)
    {
        // Init Main Menu
        $menu = $this->get("app.main_menu");
        $menu->getChild("Blog")->setCurrent(true);

        $article = $this->get(ArticleManager::class)->getArticleByIdOrUrl($slug);
        if (!$article) {
            throw $this->createNotFoundException('Unable to find AmlBlogBundle:Blog entity.');
        }

        $request->attributes->set('label', $article->getTitle());

        $em = $this->getDoctrine()->getManager();

        return [
            'entity'     => $article,
            'categories' => $em->getRepository(Category::class)->findAll(),
            'tags'       => $em->getRepository(Tags::class)->findAll(),
        ];
    }
}
