<?php
namespace Aml\Bundle\WebBundle\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BlogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('body','textarea', array(
            	'label' => 'Texte',
            	'attr' => array('size' => 15, 'data-help' => 'Texte de l\'article'),
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
        return 'aml_bundle_WebBundle_blogtype';
    }
}
