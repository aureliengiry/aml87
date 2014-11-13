<?php

namespace Aml\Bundle\EvenementsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Aml\Bundle\BlogBundle\Entity\Article;
use Symfony\Component\HttpFoundation\Request;

/**
 * Blog controller.
 *
 * @Route("/agenda")
 */
class AgendaController extends Controller
{
    /**
     * Function to reorder events by day
     *
     * @param $events
     * @return array
     */
    private function _formatEventByDay($events)
    {
        $eventsByDay = array();

        foreach ($events as $event) {
            $dateEvent = $event->getDateStart();
            $dateKey = new \DateTime();
            $dateKey->setDate($dateEvent->format('Y'), $dateEvent->format('m'), $dateEvent->format('d'));
            $dateKey->setTime(0, 0);

            $day = $dateKey->getTimestamp();

            $eventsByDay[$day][] = $event;
        }

        return $eventsByDay;
    }

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
        $events = $evenementRepository->getNextEvenements(array(
                'public' => 1,
                'archive' => 0,
                'type' => \Aml\Bundle\EvenementsBundle\Entity\Evenement::EVENEMENT_TYPE_CONCERT)
        );
        $entities = $this->_formatEventByDay($events);

        return array('entities' => $entities);
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
    public function showAction($id = false, $url_key = null)
    {
        $em = $this->getDoctrine()->getManager();

        if (false === $id) {
            $entity = $em->getRepository('AmlEvenementsBundle:Evenement')->findOneBy(array('url' => $url_key));
        } else {
            $entity = $em->getRepository('AmlEvenementsBundle:Evenement')->find($id);
        }

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AmlEvenementsBundle:Evenement entity.');
        }

        return array(
            'entity' => $entity);
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
