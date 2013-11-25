<?php

namespace Aml\Bundle\BlogBundle\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BlogCategoriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description');
    }

    public function getName()
    {
        return 'aml_bundle_blogbundle_BlogCategoriestype';
    }
}
