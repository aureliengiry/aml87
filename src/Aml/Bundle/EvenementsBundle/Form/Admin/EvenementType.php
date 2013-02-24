<?php

namespace Aml\Bundle\EvenementsBundle\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('title','text',array(
                'label' => 'Titre'
            ))
            ->add('type', 'choice', array(
                'label' => 'Type d\'événement',
                'choices'   => \Aml\Bundle\EvenementsBundle\Entity\Evenement::getTypesEvenements(),
                'multiple' => false,
                'empty_value' => 'Sélectionnez le type d\'événement'
            ))
            ->add('dateStart', 'datetime', array( // genemu_jquerydate ne marche plus
            		'label' => 'Date',
            		'date_widget' => 'single_text',
            		'time_widget' => 'single_text',
            		'input'  => 'datetime',
            		'date_format' => 'dd/MM/yyyy'
            ))
            ->add('description')
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

    public function getName()
    {
        return 'aml_bundle_evenementsbundle_concerttype';
    }
}
