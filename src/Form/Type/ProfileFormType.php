<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ProfileFormType.
 */
class ProfileFormType extends AbstractType
{
    public function getName()
    {
        return 'aml_user_profile';
    }

    /**
     * Builds the embedded form representing the user.
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'firstname',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'lastname',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'phone',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'mobile',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'birthdate',
                DateType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'job',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'adresse',
                TextareaType::class,
                [
                    'required' => false,
                ]
            );
    }

    public function getParent()
    {
        return \FOS\UserBundle\Form\Type\ProfileFormType::class;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Ici, une clé unique par formulaire pour la génération du jeton CSRF
            'intention' => 'aml_user_profile_form',
        ]);
    }
}
