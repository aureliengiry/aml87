<?php
namespace Aml\Bundle\EvenementsBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;


class EvenementAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title','text',array(
                'label' => 'Titre'
            ))
            ->add('type', 'choice', array(
                'label' => 'Type d\'événement',
                'choices'   => \Aml\Bundle\EvenementsBundle\Entity\Evenement::getTypesEvenements(),
                'multiple' => false,
                'empty_value' => 'Sélectionnez le type d\'événement'
            ))
            ->add('description','textarea', array(
                'required' => false
            ))

            ->with('Articles')
                ->add('articlesBlog','sonata_type_collection', array(
                        'type_options' => array('delete' => false),
                    ),
                    array(
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable' => 'id',
                ))
            ->end()
            ->with('Partenaires')
                ->add('partenaires','sonata_type_collection', array(
                        'type_options' => array('delete' => false),
                    ),
                    array(
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable' => 'id',
                ))
            ->end()
            ->add('archive','checkbox',array(
                'label' => 'Archiver',
                'required' => false
            ))
            ->add('public','checkbox',array(
                'label' => 'Publier',
                'required' => false
            ))

        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
        ;
    }



}