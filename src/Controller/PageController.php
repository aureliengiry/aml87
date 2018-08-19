<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Controller;

use App\Entity\Page;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Page controller.
 *
 * @Route("/")
 */
class PageController extends Controller
{
    /**
     * @Route("/page/{page}", name="page_show")
     * @Route("/{page}.html", name="page_show_rewrite")
     * @Template("page/index.html.twig"))
     * @Method("GET")
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

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AmlWebBundle:Page entity.');
        }

        $request->attributes->set('label', $entity->getTitle());

        return [
            'entity' => $entity,
        ];
    }
}
