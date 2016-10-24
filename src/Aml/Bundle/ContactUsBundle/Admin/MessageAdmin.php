<?php
namespace Aml\Bundle\ContactUsBundle\Admin;

use Aml\Bundle\ContactUsBundle\Entity\Message;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Form\FormMapper;

class MessageAdmin extends AbstractAdmin
{
    // setup the default sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        '_sort_by' => 'created'
    );

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text',
                array(
                    'required' => false,
                    'disabled' => true
                ))
            ->add('subject', 'text',
                array(
                    'required' => false,
                    'disabled' => true
                ))
            ->add('body', 'textarea',
                array(
                    'required' => false,
                    'disabled' => true
                ))
            ->add('created', 'datetime',
                array(
                    'widget' => 'single_text',
                    'required' => false,
                    'disabled' => true
                ))
            ->add('email', 'email',
                array(
                    'required' => false,
                    'disabled' => true
                ))
            ->add('addressIp', 'text', array(
                'required' => false,
                'disabled' => true
            ))
            ->add(
                'status',
                'choice',
                array(
                    'choices' => array(
                        Message::MESSAGE_STATUS_SAVE => 'Enregistré',
                        Message::MESSAGE_STATUS_SAVE_SEND => 'Enregistré & envoyé'
                    ),
                    'required' => false,
                    'placeholder' => 'Choose status'
                )
            )
            ->add('spam', 'text', array(
                'required' => false,
                'disabled' => true
            ))
        ;
    }

    public function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->addIdentifier('subject')
            ->add('created')
            ->add('email')
            ->add('addressIp')
            ->add('status', 'string')
            ->add('spam')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('email')
            ->add('addressIp')
            ->add('spam')
        ;
    }

}