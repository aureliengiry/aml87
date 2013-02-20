<?php

namespace Aml\Bundle\UsersBundle\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\CallbackValidator;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormError;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email','email',array(
            	'label' => 'Adresse Email'
            ))
            ->add('login')
//            ->add('password', 'repeated', array(
//            	'type' => 'password',
//            	'first_name' => 'password',
//            	'second_name' => 'confirmation',
//                'first_options' => array
//                (
//                    'label' => 'Mot de passe' 
//                ),
//				'attr' => array('data-help' => 'Veuillez renseigner un mot de passe pour pouvoir accéder à votre espace. Tout caractère sauf l\'espace.')
//            ))
			->add('password','password')
            ->add('civilite')
            ->add('nom')
            ->add('prenom')
            ->add('adresse')
            ->add('avatar')
        ;
    }

    public function getName()
    {
        return 'aml_bundle_usersbundle_usertype';
    }
}
