<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Page\Ui\Controller;

use App\Core\Infrastructure\Adapter\Doctrine\PageDoctrineAdapter;
use App\Page\Domain\Exception\PageNotFoundException;
use App\Page\Domain\ObtainPageInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Page controller.
 *
 * @Route("/")
 */
class PageController extends AbstractController
{
    /** @var ObtainPageInterface */
    private $pageAdapter;

    public function __construct(PageDoctrineAdapter $pageAdapter)
    {
        $this->pageAdapter = $pageAdapter;
    }

    /**
     * @Route("/page/{page}", name="page_show", methods={"GET"})
     * @Route("/{page}.html", name="page_show_rewrite", methods={"GET"})
     *
     * @Template("page/index.html.twig"))
     */
    public function index(Request $request, string $page)
    {
        try {
            $page = $this->pageAdapter->getPublicPageBySlug($page);
            $request->attributes->set('label', $page->getTitle());
        } catch (PageNotFoundException $pageNotFoundException) {
            throw $this->createNotFoundException($pageNotFoundException->getMessage());
        }

        return [
           'page' => $page,
       ];
    }
}
