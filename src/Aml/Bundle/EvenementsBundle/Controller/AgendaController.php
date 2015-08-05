<?php

namespace Aml\Bundle\EvenementsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Blog controller.
 *
 * @Route("/agenda")
 */
class AgendaController extends Controller
{
    /**
     * Lists all Blog entities.
     *
     * @Route("/", name="agenda")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $evenementRepository = $em->getRepository('AmlEvenementsBundle:Evenement');
        $events = $evenementRepository->getNextEvenements(
            array(
                'public' => 1,
                'archive' => 0,
                'type' => \Aml\Bundle\EvenementsBundle\Entity\Evenement::EVENEMENT_TYPE_CONCERT
            )
        );

        return array('entities' => $events);
    }

    /**
     * Finds and displays a Evenement entity.
     *
     * @Route("/show/{id}", name="agenda_show_event")
     * @Route("/evenement/{url_key}.html", name="agenda_show_event_rewrite")
     * @Template()
     *
     * @param bool $id
     * @param string $url_key
     *
     * @return array
     */
    public function showAction($id = false, $url_key = null, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if (false === $id) {
            $entity = $em->getRepository('AmlEvenementsBundle:Evenement')->getEventByUrlKey($url_key);
        } else {
            $entity = $em->getRepository('AmlEvenementsBundle:Evenement')->find($id);
        }

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AmlEvenementsBundle:Evenement entity.');
        }

        // Init Main Menu
        $menu = $this->get("app.main_menu");
        $menu->getChild("Agenda")->setCurrent(true);

        $request->attributes->set('label', $entity->getTitle());

        return array(
            'entity' => $entity
        );
    }

    /**
     * Action for Next Concert Block
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function nextConcertAction()
    {
        // getNextConcert
        $repo = $this->getDoctrine()->getRepository('AmlEvenementsBundle:Evenement');
        $nextConcert = $repo->getNextConcert();

        return $this->render(
            'AmlEvenementsBundle::Blocs/blocNextConcert.html.twig',
            array('nextConcert' => $nextConcert)
        );
    }


}
