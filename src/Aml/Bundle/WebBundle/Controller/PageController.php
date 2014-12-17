<?php

namespace Aml\Bundle\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Aml\Bundle\WebBundle\Entity\Page;

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
     * @Template("AmlWebBundle:Page:index.html.twig"))
     */
    public function indexAction($id = false, $url_key = null)
    {
        $em = $this->getDoctrine()->getManager();

        if (false === $id) {
            $entity = $em->getRepository('AmlWebBundle:Page')->findOneBy(
                array(
                    'url' => $url_key,
                    'public' => 1
                )
            );
        } else {
            $entity = $em->getRepository('AmlWebBundle:Page')->findOneBy(
                array(
                    'id' => $id,
                    'public' => 1
                )
            );
        }

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AmlWebBundle:Page entity.');
        }

        return array(
            'entity' => $entity,
        );
    }
}
