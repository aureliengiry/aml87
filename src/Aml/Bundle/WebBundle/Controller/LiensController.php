<?php

namespace Aml\Bundle\WebBundle\Controller;

use Aml\Bundle\WebBundle\Entity\Link;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Blog controller.
 *
 * @Route("/liens")
 */
class LiensController extends Controller
{
    /**
     * Lists all Blog entities.
     *
     * @Route("/", name="liens")
     * @Template("liens/index.html.twig")
     * @Method("GET")
     */
    public function indexAction()
    {
        return [
            'entities' => $this->getDoctrine()->getManager()->getRepository(Link::class)->getPublicLinks()
        ];
    }
}
