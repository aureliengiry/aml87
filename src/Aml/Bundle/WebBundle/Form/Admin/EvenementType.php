<?php

namespace Aml\Bundle\WebBundle\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('dateStart')
            ->add('dateStart', 'datetime', array( // genemu_jquerydate ne marche plus
            		'label' => 'Date',
            		'date_widget' => 'single_text',
            		'time_widget' => 'single_text',
            		'input'  => 'datetime',
            		'date_format' => 'dd/MM/yyyy',
            		'data' => new \DateTime(),
            		'attr' => array( 'data-help' => 'Date de l\'événement'),
            ))
//             //heure
//             ->add('lieu', 'text', array(
//             		'label' => 'Lieu',
//             		'attr' => array('size' => 15, 'data-help' => 'Lieu de l\'évenement'),
//             ))
            ->add('title')
            ->add('description')
            ->add('archive')
            ->add('public')
        ;
    }

    public function getName()
    {
        return 'aml_bundle_WebBundle_concerttype';
    }
}
