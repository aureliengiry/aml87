<?php

namespace App\Controller;

use App\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
 * Page controller.
 *
 * @Route("/")
 */
class PageController extends Controller
{
    /**
     * @Route("/page/{id}", name="page_show")
     * @Route("/{url_key}.html", name="page_show_rewrite")
     * @Template("page/index.html.twig"))
     * @Method("GET")
     */
    public function indexAction($id = false, $url_key = null, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if (false === $id) {
            $entity = $em->getRepository(Page::class)->getPublicPageByUrlKey($url_key);
        } else {
            $entity = $em->getRepository(Page::class)->findOneBy([
                'id'     => $id,
                'public' => Page::PAGE_IS_PUBLIC
            ]);
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
