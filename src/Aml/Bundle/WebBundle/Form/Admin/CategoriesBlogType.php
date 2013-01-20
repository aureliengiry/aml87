<?php

namespace Aml\Bundle\WebBundle\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BlogCategoriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('system_name')
            ->add('name')
        ;
    }

    public function getName()
    {
        return 'aml_bundle_webbundle_BlogCategoriestype';
    }
}
