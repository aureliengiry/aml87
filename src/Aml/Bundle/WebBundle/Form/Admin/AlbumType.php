<?php

namespace Aml\Bundle\WebBundle\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title','text',array('label' => 'Titre'))       
            ->add('date', 'date', array(
					'label' => 'Date de sortie',
					'widget' => 'single_text',
					'format' => 'dd/MM/yyyy',
					'required' => false,
					'attr' => array('readonly' => 'readonly')
			))
            ->add('description','textarea', array(
            	'label' => 'Description',
            	'attr' => array('size' => 15, 'data-help' => 'Description de l\'album'),
            	'required' => false,
            ))
            ->add('public','checkbox',array(
            	'label' => 'Statut',
            	'required' => false,
            	'attr' => array('data-help' => 'Signifie que la formation n\'a pas lieu dans les locaux d\'Idéal Connaissances'),
            ))
        ;
    }

    public function getName()
    {
        return 'aml_bundle_WebBundle_albumtype';
    }
}
