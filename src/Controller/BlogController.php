<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Controller;

use App\Article\ArticleManager;
use App\Entity\Category;
use Knp\Menu\MenuItem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Blog controller.
 *
 * @Route("/blog")
 */
final class BlogController extends AbstractController
{
    protected int $_limitPagination = 5;

    public function __construct(
        private readonly ArticleManager $articleManager,
        private readonly MenuItem $appMainMenu,
        private readonly Environment $twig
    ) {
    }

    /**
     * Lists all Blog entities.
     *
     * @Route("/{page}", name="blog", requirements={"page" = "\d+"}, defaults={"page" = 1}, methods={"GET"})
     */
    public function index(Request $request, int $page): Response
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
        $nbPublicArticles = is_countable($publicArticles) ? \count($publicArticles) : 0;

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

        return new Response($this->twig->render(
            'blog/index.html.twig',
            [
                'entities' => $publicArticles,
                'pagination' => $pagination,
                'categories' => $em->getRepository(Category::class)->getCategoriesWithNbArticles(),
                'tags' => $this->articleManager->getTagsWithNbArticles(),
            ]
        ));
    }

    /**
     * Finds and displays a Blog entity.
     *
     * @Route("/article/{slug}.html", name="blog_show", methods={"GET"})
     */
    public function show(string $slug, Request $request): Response
    {
        // Init Main Menu
        $this->appMainMenu->getChild('Blog')->setCurrent(true);

        $article = $this->articleManager->getArticleByIdOrUrl($slug);
        if ( ! $article) {
            throw $this->createNotFoundException('Unable to find Blog entity.');
        }

        $request->attributes->set('label', $article->getTitle());

        $em = $this->getDoctrine()->getManager();

        return new Response($this->twig->render(
            'blog/show.html.twig',
            [
                'entity' => $article,
                'categories' => $em->getRepository(Category::class)->getCategoriesWithNbArticles(),
                'tags' => $this->articleManager->getTagsWithNbArticles(),
            ]
        ));
    }
}
