<?php
namespace Aml\Bundle\EvenementsBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

use Aml\Bundle\BlogBundle\Admin\BlogAdmin;


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

            ->add('dateStart')

            ->add('picture','sonata_type_admin',array(
                'delete' => false,
                'required' => false
            ))

            ->add('description','textarea', array(
                'required' => false
            ))

            ->with('Articles')
                ->add('articles', 'sonata_type_model', array(
                    'required' => false,
                    'expanded' => true,
                    'multiple' => true,
                    'by_reference' => false
                ))
            ->end()
            ->with('Partenaires')
                ->add('partenaires', 'sonata_type_model', array(
                    'required' => false,
                    'expanded' => true,
                    'multiple' => true,
                    'by_reference' => false
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
        $datagridMapper
            ->add('title')
            ->add('type')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->addIdentifier('type')
            ->addIdentifier('dateStart')
        ;
    }



}