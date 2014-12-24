<?php
namespace Aml\Bundle\EvenementsBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class SeasonAdmin
 * @package Aml\Bundle\EvenementsBundle\Admin
 */
class SeasonAdmin extends Admin
{
    // setup the default sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        '_sort_by' => 'dateStart'
    );

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
            ->add('name')
            ->add('dateStart', 'date', array(
                'label' => 'Date de début de saison',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'required' => false,
                // 'attr' => array('readonly' => 'readonly')
            ))
            ->add('dateEnd', 'date', array(
                'label' => 'Date de fin de saison',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'required' => false,
                // 'attr' => array('readonly' => 'readonly')
            ))
            ->end()
            ->with('Evenements')
            ->add('evenements', 'sonata_type_model', array(
                'required' => false,
                'expanded' => true,
                'multiple' => true,
                'by_reference' => false
            ))
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('dateStart')
            ->add('dateEnd')
        ;
    }



}