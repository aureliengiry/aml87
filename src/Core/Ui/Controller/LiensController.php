<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Core\Ui\Controller;

use App\Core\Domain\Model\Link;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Blog controller.
 *
 * @Route("/liens")
 */
class LiensController extends AbstractController
{
    /**
     * Lists all link entities.
     *
     * @Route("/", name="liens", methods={"GET"})
     * @Template("liens/index.html.twig")
     */
    public function index()
    {
        return [
            'entities' => $this->getDoctrine()->getManager()->getRepository(Link::class)->getPublicLinks(),
        ];
    }
}
