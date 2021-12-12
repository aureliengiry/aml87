<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Controller;

use App\Entity\Page;
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
    /**
     * @Route("/page/{page}", name="page_show", methods={"GET"})
     * @Route("/{page}.html", name="page_show_rewrite", methods={"GET"})
     * @Template("page/index.html.twig"))
     */
    public function index(Request $request, $page)
    {
        $em = $this->getDoctrine()->getManager();

        if (is_numeric($page)) {
            $entity = $em->getRepository(Page::class)->findOneBy([
                'id' => $page,
                'public' => Page::PAGE_IS_PUBLIC,
            ]);
        } else {
            $entity = $em->getRepository(Page::class)->getPublicPageByUrlKey($page);
        }

        if ( ! $entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $request->attributes->set('label', $entity->getTitle());

        return [
            'entity' => $entity,
        ];
    }
}
