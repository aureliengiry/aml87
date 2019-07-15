<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Core\Ui\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class MessageType.
 */
class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('email', EmailType::class)
            ->add('subject', TextType::class)
            ->add(
                'body',
                TextareaType::class,
                [
                    'attr' => [
                        'size' => 15,
                        'data-help' => 'Texte de l\'article',
                    ],
                ]
            )
            ->add(
                'spam',
                TextType::class,
                [
                    'required' => false,
                    'attr' => ['style' => 'display:none'],
                    'label' => false,
                ]
            )
            ->add(
                'send',
                SubmitType::class,
                [
                    'attr' => ['class' => 'btn btn-primary pull-right'],
                ]
            );
    }

    public function getName()
    {
        return 'aml_bundle_WebBundle_messagetype';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                // Ici, une clé unique par formulaire pour la génération du jeton CSRF
                'intention' => 'aml_user_profile_form',
            ]
        );
    }
}
