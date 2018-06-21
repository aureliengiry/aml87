<?php

namespace App\Controller;

use App\Discography\DiscographyManager;
use App\Entity\Album;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController.
 *
 * @Route("/discographie")
 */
class DiscographyController extends Controller
{
    /**
     * Lists all Album entities.
     *
     * @Route("/", name="discography")
     * @Template("discography/index.html.twig")
     * @Method("GET")
     */
    public function indexAction()
    {
        return ['entities' => $this->container->get(DiscographyManager::class)->getPublicAlbums()];
    }

    /**
     * Finds and displays a Album entity.
     *
     * @Route("/album/id/{id}", name="discography_album_show")
     * @Route("/album/{url_key}.html", name="discography_album_show_rewrite")
     * @Template("discography/show.html.twig")
     * @Method("GET")
     */
    public function showAction($id = false, $url_key = null, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $albumRepository = $em->getRepository(Album::class);
        if (false === $id || !empty($url_key)) {
            $entity = $albumRepository->getAlbumByUrlKey($url_key);
        } else {
            $entity = $albumRepository->find($id);
        }

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Album entity.');
        }

        // Init Main Menu
        $menu = $this->get('app.main_menu');
        $menu->getChild('Discographie')->setCurrent(true);

        $request->attributes->set('label', $entity->getTitle());

        return [
            'entity' => $entity,
        ];
    }
}
