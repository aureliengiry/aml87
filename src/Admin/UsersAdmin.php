<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class UsersAdmin.
 *
 * @author      Aurélien GIRY <aurelien.giry@gmail.com>
 */
class UsersAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('username')
                ->add('email')
            ->end()
            ->with('Profile')
                ->add(
                    'firstname',
                    TextType::class,
                    [
                        'required' => false,
                    ]
                )
                ->add(
                    'lastname',
                    TextType::class,
                    [
                        'required' => false,
                    ]
                )
                ->add(
                    'phone',
                    TextType::class,
                    [
                        'required' => false,
                    ]
                )
                ->add(
                    'mobile',
                    TextType::class,
                    [
                        'required' => false,
                    ]
                )
                ->add(
                    'birthdate',
                    DateType::class,
                    [
                        'widget' => 'single_text',
                        'required' => false,
                    ]
                )
                ->add(
                    'job',
                    TextType::class,
                    [
                        'required' => false,
                    ]
                )
                ->add(
                    'adresse',
                    TextareaType::class,
                    [
                        'required' => false,
                    ]
                )
                ->add(
                    'enabled',
                    CheckboxType::class,
                    [
                        'label' => 'Actif',
                        'required' => false,
                    ]
                )
            ->end()
            ->with('Management')
                ->add('enabled', null, ['required' => false])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('email')
            ->add('username')
            ->add('enabled');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('username')
            ->add('email')
            ->add('name', 'string', ['template' => 'Admin/User/Fields/name.html.twig'])
            ->add('lastLogin')
            ->add('locked')
            ->add('enabled');
    }
}
