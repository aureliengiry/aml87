<?php

namespace Aml\Bundle\WebBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title','text',array('label' => 'Titre'))   
            ->add('file')
        ;
    }

    public function getName()
    {
        return 'aml_bundle_webbundle_filetype';
    }
}
