<?php

namespace Aml\Bundle\EvenementsBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Aml\Bundle\EvenementsBundle\Entity\Evenement;
use Aml\Bundle\EvenementsBundle\Form\Admin\EvenementType;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Concert controller.
 *
 * @Route("/admin/agenda")
 */
class AgendaController extends Controller
{
	protected $_limitPagination = 5;
	
	
	private function _formatEventByDay( $events ){
		$eventsByDay = array();
		
		foreach ( $events as $event ){
			
			$dateEvent = $event->getDateStart();
			$dateKey = new \DateTime();
			$dateKey->setDate($dateEvent->format('Y'), $dateEvent->format('m'), $dateEvent->format('d')  );
			$dateKey->setTime(0,0);			
		
			$day = $dateKey->getTimestamp();
			
			$eventsByDay[$day][] = $event;
			
		}
		
		//var_dump('<pre>',$eventsByDay);exit;
		return $eventsByDay;
	}
    /**
     * Lists all Concert entities.
     *
     * @Route("/", name="admin_agenda")
     * @Template()
     */
    public function indexAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$evenementRepository = $em->getRepository('AmlEvenementsBundle:Evenement');

        // Init Display mode
    	$requestMode = $request->query->get('mode');
    	if( isset($requestMode) && !empty($requestMode) ){
			$mode = $requestMode;    		
    	}
    	else{
    		$mode = 'calendar';
    	}

    	if( 'list' === $mode ){
    		//$events = $evenementRepository->getNextEvenements();
    		$events = $evenementRepository->findAll();
    		$entities = $this->_formatEventByDay( $events );
    	}
    	else{
    		$entities = $evenementRepository->findAll();
    	}
        
        
       

        return array(
        		'entities' => $entities,
        		'mode' => $mode
        );
    }
    /**
     * Lists all Concert entities.
     *
     * @Route("/ajax_get_feed", name="admin_agenda_ajax_feed")
     * @Template()
     */
    public function ajaxGetFeedAction(Request $request)
    {
    	$eventsArray = array();
    	$data = $request->request->all();
    	
    	$em = $this->getDoctrine()->getManager();
    	$entities = $em->getRepository('AmlEvenementsBundle:Evenement')->getEvenementsCalendar($data['start'], $data['end']);
    	
    	
    	foreach( $entities as $entity ){
    		$eventsArray[] = array(
    			'id' => $entity->getId(),
    			'title' => $entity->getTitle(),
    			'start' => $entity->getDateStart()->format('Y-m-d'),
    			'description' => $entity->getDescription()
    		);
    	}
			
		return new Response( json_encode( $eventsArray ) );
        //var_dump($data,$entities);exit;
    }

    /**
     * Displays a form to create a new Concert entity.
     *
     * @Route("/new", name="admin_agenda_new_event")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Evenement();
        $form   = $this->createForm(new EvenementType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Concert entity.
     *
     * @Route("/create", name="content_agenda_create")
     * @Method("post")
     * @Template("AmlEvenementsBundle:Concert:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Evenement();
        $request = $this->getRequest();
        $form    = $this->createForm(new EvenementType(), $entity);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_agenda'));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Concert entity.
     *
     * @Route("/{id}/edit", name="admin_agenda_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AmlEvenementsBundle:Evenement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Concert entity.');
        }

        $editForm = $this->createForm(new EvenementType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Concert entity.
     *
     * @Route("/{id}/update", name="admin_agenda_update")
     * @Method("post")
     * @Template("AmlEvenementsBundle:Concert:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AmlEvenementsBundle:Evenement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Concert entity.');
        }

        $editForm   = $this->createForm(new EvenementType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_agenda'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Concert entity.
     *
     * @Route("/{id}/delete", name="admin_agenda_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AmlEvenementsBundle:Evenement')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Concert entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('content_agenda'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
