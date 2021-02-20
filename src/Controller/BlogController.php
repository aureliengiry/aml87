<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Controller;

use App\Article\ArticleManager;
use App\Entity\Category;
use Knp\Menu\MenuItem;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Blog controller.
 *
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    protected $_limitPagination = 5;

    /** @var ArticleManager */
    private $articleManager;

    /** @var MenuItem */
    private $appMainMenu;

    public function __construct(ArticleManager $articleManager, MenuItem $appMainMenu)
    {
        $this->articleManager = $articleManager;
        $this->appMainMenu = $appMainMenu;
    }

    /**
     * Lists all Blog entities.
     *
     * @Route("/{page}", name="blog",requirements={"page" = "\d+"}, defaults={"page" = 1}, methods={"GET"})
     * @Template("blog/index.html.twig")
     */
    public function index(Request $request, $page)
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

        $publicArticles = $this->articleManager->getPublicArticlesWithPagination($page, $filters);
        $nbPublicArticles = \count($publicArticles);

        // Calcul de la pagination
        $calculLastPage = round($nbPublicArticles / $this->_limitPagination);
        $pagination = [
            'nbEntities' => $nbPublicArticles,
            'nbPages' => ceil($nbPublicArticles / $this->_limitPagination),
            'limit' => $this->_limitPagination,
            'currentPage' => $page,
            'nextPage' => ($page + 1 * $this->_limitPagination < $nbPublicArticles ? $page + 1 : false),
            'prevPage' => ($page - 1 > 0 ? $page - 1 : false),
            'lastPage' => ($calculLastPage >= 0 ? $calculLastPage : 0),
        ];

        return [
            'entities' => $publicArticles,
            'pagination' => $pagination,
            'categories' => $em->getRepository(Category::class)->getCategoriesWithNbArticles(),
            'tags' => $this->articleManager->getTagsWithNbArticles(),
        ];
    }

    /**
     * Finds and displays a Blog entity.
     *
     * @Route("/article/{slug}.html", name="blog_show", methods={"GET"})
     * @Template("blog/show.html.twig")
     */
    public function show($slug, Request $request)
    {
        // Init Main Menu
        $this->appMainMenu->getChild('Blog')->setCurrent(true);

        $article = $this->articleManager->getArticleByIdOrUrl($slug);
        if (!$article) {
            throw $this->createNotFoundException('Unable to find Blog entity.');
        }

        $request->attributes->set('label', $article->getTitle());

        $em = $this->getDoctrine()->getManager();

        return [
            'entity' => $article,
            'categories' => $em->getRepository(Category::class)->getCategoriesWithNbArticles(),
            'tags' => $this->articleManager->getTagsWithNbArticles(),
        ];
    }
}
