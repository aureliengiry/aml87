<?php

namespace App\Controller;

use App\Entity\Link;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
            'entities' => $this->getDoctrine()->getManager()->getRepository(Link::class)->getPublicLinks(),
        ];
    }
}
