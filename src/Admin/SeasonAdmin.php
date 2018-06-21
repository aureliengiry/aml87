<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\Filter\DateType;
use Sonata\AdminBundle\Form\Type\ModelType;

/**
 * Class SeasonAdmin.
 */
class SeasonAdmin extends AbstractAdmin
{
    // setup the default sort column and order
    protected $datagridValues = [
        '_sort_order' => 'DESC',
        '_sort_by' => 'dateStart',
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
            ->add('name')
            ->add(
                'dateStart',
                DateType::class,
                [
                    'label' => 'Date de début de saison',
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                ]
            )
            ->add(
                'dateEnd',
                DateType::class,
                [
                    'label' => 'Date de fin de saison',
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                ]
            )
            ->end()
            ->with('Evenements')
            ->add(
                'evenements',
                ModelType::class,
                [
                    'required' => false,
                    'expanded' => true,
                    'multiple' => true,
                    'by_reference' => false,
                ]
            )
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('dateStart')
            ->add('dateEnd');
    }
}
