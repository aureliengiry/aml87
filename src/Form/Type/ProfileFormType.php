<?php
/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

/**
 * Class ProfileFormType
 *
 * @package App\Form\Type
 */
class ProfileFormType extends AbstractType
{
    public function getName()
    {
        return 'aml_user_profile';
    }

    /**
     * Builds the embedded form representing the user.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
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
        return 'fos_user_profile';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            // Ici, une clé unique par formulaire pour la génération du jeton CSRF
            'intention' => 'aml_user_profile_form',
        ));
    }
}
