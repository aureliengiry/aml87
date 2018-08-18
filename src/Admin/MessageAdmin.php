<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Admin;

use App\Entity\Message;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class MessageAdmin.
 */
class MessageAdmin extends AbstractAdmin
{
    // setup the default sort column and order
    protected $datagridValues = [
        '_sort_order' => 'DESC',
        '_sort_by' => 'created',
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add(
                'name',
                TextType::class,
                [
                    'required' => false,
                    'disabled' => true,
                ]
            )
            ->add(
                'subject',
                TextType::class,
                [
                    'required' => false,
                    'disabled' => true,
                ]
            )
            ->add(
                'body',
                TextareaType::class,
                [
                    'required' => false,
                    'disabled' => true,
                ]
            )
            ->add(
                'created',
                DateTimeType::class,
                [
                    'widget' => 'single_text',
                    'required' => false,
                    'disabled' => true,
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'required' => false,
                    'disabled' => true,
                ]
            )
            ->add(
                'addressIp',
                TextType::class,
                [
                    'required' => false,
                    'disabled' => true,
                ]
            )
            ->add(
                'status',
                ChoiceType::class,
                [
                    'choices' => [
                        Message::MESSAGE_STATUS_SAVE => 'Enregistré',
                        Message::MESSAGE_STATUS_SAVE_SEND => 'Enregistré & envoyé',
                    ],
                    'required' => false,
                    'placeholder' => 'Choose status',
                ]
            )
            ->add(
                'spam',
                TextType::class,
                [
                    'required' => false,
                    'disabled' => true,
                ]
            );
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
            ->add('spam');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('email')
            ->add('addressIp')
            ->add('spam');
    }
}
