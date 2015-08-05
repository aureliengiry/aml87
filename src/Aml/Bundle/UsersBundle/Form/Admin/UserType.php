<?php

namespace Aml\Bundle\UsersBundle\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'email',
                'email',
                array(
                    'label' => 'Adresse Email'
                )
            )
            ->add('login')
            ->add('password', 'password')
            ->add('civilite')
            ->add('nom')
            ->add('prenom')
            ->add('adresse')
            ->add('avatar');
    }

    public function getName()
    {
        return 'aml_bundle_usersbundle_usertype';
    }
}
