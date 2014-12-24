<?php
namespace Aml\Bundle\EvenementsBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

use Aml\Bundle\BlogBundle\Admin\BlogAdmin;

/**
 * Class EvenementAdmin
 * @package Aml\Bundle\EvenementsBundle\Admin
 */
class EvenementAdmin extends Admin
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
                ->add('title','text',array(
                    'label' => 'Titre'
                ))
                ->add('type', 'choice', array(
                    'label' => 'Type d\'événement',
                    'choices'   => \Aml\Bundle\EvenementsBundle\Entity\Evenement::getTypesEvenements(),
                    'multiple' => false,
                    'empty_value' => 'Sélectionnez le type d\'événement'
                ))

                ->add('season', 'entity', array(
                    'label' => 'Saison',
                    'class' => 'AmlEvenementsBundle:Season',
                    'property' => 'name',
                    'empty_value' => 'Sélectionnez une saison',
                    'attr' => array('class'=>'uiform')
                ))

                ->add('dateStart', 'date', array(
                    'label' => 'Date',
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                    // 'attr' => array('readonly' => 'readonly')
                ))

                ->add('picture','sonata_type_admin',array(
                    'delete' => false,
                    'required' => false
                ))

                ->add('description','textarea', array(
                    'required' => false,
                    'wysiwyg' => true
                ))
                ->add('archive','checkbox',array(
                    'label' => 'Archiver',
                    'required' => false
                ))
                ->add('public','checkbox',array(
                    'label' => 'Publier',
                    'required' => false
                ))
            ->end()
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
            ->add('archive')
            ->add('public')
        ;
    }



}