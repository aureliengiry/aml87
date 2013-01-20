<?php

namespace Aml\Bundle\WebBundle\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('body')
            ->add('created')
            ->add('updated')
            ->add('public')
            ->add('url')
        ;
    }

    public function getName()
    {
        return 'aml_bundle_WebBundle_pagetype';
    }
}
