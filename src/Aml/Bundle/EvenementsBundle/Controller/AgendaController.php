<?php

namespace Aml\Bundle\EvenementsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Aml\Bundle\BlogBundle\Entity\Article;

/**
 * Blog controller.
 *
 * @Route("/agenda")
 */
class AgendaController extends Controller
{
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

        //var_dump('<pre>',$eventsByDay);exit;
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
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        /*if( false === $id ){
            $entity = $em->getRepository('AmlEvenementsBundle:Evenement')->findOneBy(array('url' => $url_key));
        }
        else{   */
        $entity = $em->getRepository('AmlEvenementsBundle:Evenement')->find($id);
        // }

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AmlEvenementsBundle:Evenement entity.');
        }

        return array(
            'entity' => $entity);
    }


}
