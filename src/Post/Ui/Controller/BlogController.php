<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Post\Ui\Controller;

use App\Core\Domain\Category\ObtainCategoriesInterface;
use App\Core\Domain\Tag\ObtainTagsInterface;
use App\Core\Infrastructure\Adapter\Doctrine\CategoryBlogDoctrineAdapter;
use App\Core\Infrastructure\Adapter\Doctrine\TagBlogDoctrineAdapter;
use App\Post\Domain\Exception\PostNotFoundException;
use App\Post\Domain\Model\Post;
use App\Post\Domain\Services\PostManager;
use App\Post\Domain\PostsInterface;
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

    /** @var MenuItem */
    private $appMainMenu;

    /** @var PostsInterface */
    private $articles;

    /** @var ObtainCategoriesInterface */
    private $obtainCategories;

    /** @var ObtainTagsInterface */
    private $obtainTags;

    /**
     * BlogController constructor.
     * @param MenuItem $appMainMenu
     * @param PostManager $postManager
     * @param CategoryBlogDoctrineAdapter $categoryBlogDoctrineAdapter
     * @param TagBlogDoctrineAdapter $tagBlogDoctrineAdapter
     */
    public function __construct(
        MenuItem $appMainMenu,
        PostManager $postManager,
        CategoryBlogDoctrineAdapter $categoryBlogDoctrineAdapter,
        TagBlogDoctrineAdapter $tagBlogDoctrineAdapter)
    {
        $this->appMainMenu = $appMainMenu;
        $this->articles = $postManager;
        $this->obtainCategories = $categoryBlogDoctrineAdapter;
        $this->obtainTags = $tagBlogDoctrineAdapter;
    }

    /**
     * Lists all Blog entities.
     *
     * @Route("/{page}", name="blog",requirements={"page" = "\d+"}, defaults={"page" = 1}, methods={"GET"})
     * @Template("blog/index.html.twig")
     */
    public function index(Request $request, int $page)
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

        $publicArticles = $this->articles->getPublicPostsWithPagination($page, $filters);
        $nbPublicArticles = \count($publicArticles);

        // Calcul de la pagination
        $calculLastPage = \round($nbPublicArticles / $this->_limitPagination);
        $pagination = [
            'nbEntities' => $nbPublicArticles,
            'nbPages' => \ceil($nbPublicArticles / $this->_limitPagination),
            'limit' => $this->_limitPagination,
            'currentPage' => $page,
            'nextPage' => ($page + 1 * $this->_limitPagination < $nbPublicArticles ? $page + 1 : false),
            'prevPage' => ($page - 1 > 0 ? $page - 1 : false),
            'lastPage' => ($calculLastPage >= 0 ? $calculLastPage : 0),
        ];

        return [
            'articles' => $publicArticles,
            'pagination' => $pagination,
        ];
    }

    /**
     * Finds and displays a Blog entity.
     *
     * @Route("/article/{slug}.html", name="blog_show", methods={"GET"})
     * @Template("blog/show.html.twig")
     */
    public function show(Request $request, string $slug)
    {
        try {
            /** @var Post $post */
            $post = $this->articles->getPostBySlug($slug);

            // Init Main Menu
            $this->appMainMenu->getChild('Blog')->setCurrent(true);
            $request->attributes->set('label', $post->getContent()->getTitle());
        } catch (PostNotFoundException $articleNotFoundException) {
            throw $this->createNotFoundException($articleNotFoundException->getMessage());
        }

        return [
            'article' => $post,
        ];
    }

    /**
     * Display Blog filters (cateogries, tags).
     *
     * @Route("/filters", name="blog_filters", methods={"GET"})
     * @Template("blog/filters.html.twig")
     */
    public function filters()
    {
        return [];
        return [
            'categories' => $this->obtainCategories->getCategoriesWithNbArticles(),
            'tags' => $this->obtainTags->getTagsWithNbArticles(),
        ];
    }
}
