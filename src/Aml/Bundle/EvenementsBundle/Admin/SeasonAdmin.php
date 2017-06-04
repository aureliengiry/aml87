<?php
namespace Aml\Bundle\EvenementsBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class SeasonAdmin
 * @package Aml\Bundle\EvenementsBundle\Admin
 */
class SeasonAdmin extends AbstractAdmin
{
    // setup the default sort column and order
    protected $datagridValues = [
        '_sort_order' => 'DESC',
        '_sort_by'    => 'dateStart',
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
            ->add('name')
            ->add(
                'dateStart',
                'date',
                [
                    'label'    => 'Date de début de saison',
                    'widget'   => 'single_text',
                    'format'   => 'dd/MM/yyyy',
                    'required' => false,
                ]
            )
            ->add(
                'dateEnd',
                'date',
                [
                    'label'    => 'Date de fin de saison',
                    'widget'   => 'single_text',
                    'format'   => 'dd/MM/yyyy',
                    'required' => false,
                ]
            )
            ->end()
            ->with('Evenements')
            ->add(
                'evenements',
                'sonata_type_model',
                [
                    'required'     => false,
                    'expanded'     => true,
                    'multiple'     => true,
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
