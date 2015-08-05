<?php
namespace Aml\Bundle\DiscographyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 *
 * @package Aml\Bundle\DiscographyBundle\Controller
 * @Route("/dicographie")
 */
class DiscographyController extends Controller
{
    /**
     * Lists all Album entities.
     *
     * @Route("/", name="discography")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $repo = $this->getDoctrine()->getRepository('AmlDiscographyBundle:Album');
        $entities = $repo->findBy(
            array('public' => "1"),
            array('date' => 'DESC')
        );

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Album entity.
     *
     * @Route("/album/id/{id}", name="discography_album_show")
     * @Route("/album/{url_key}.html", name="discography_album_show_rewrite")
     * @Template()
     */
    public function showAction($id = false, $url_key = null, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if (false === $id || !empty($url_key)) {
            $entity = $em->getRepository('AmlDiscographyBundle:Album')->getAlbumByUrlKey($url_key);
        } else {
            $entity = $em->getRepository('AmlDiscographyBundle:Album')->find($id);
        }

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Album entity.');
        }

        // Init Main Menu
        $menu = $this->get("app.main_menu");
        $menu->getChild("Discographie")->setCurrent(true);

        $request->attributes->set('label', $entity->getTitle());

        return array(
            'entity' => $entity
        );
    }


}
