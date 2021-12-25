<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Controller;

use App\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Page controller.
 *
 * @Route("/")
 */
final class PageController extends AbstractController
{
    /**
     * @Route("/page/{page}", name="page_show", methods={"GET"})
     * @Route("/{page}.html", name="page_show_rewrite", methods={"GET"})
     */
    public function index(Request $request, $page, Environment $twig): Response
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

        return new Response($twig->render('page/index.html.twig', [
            'entity' => $entity,
        ]));
    }
}
