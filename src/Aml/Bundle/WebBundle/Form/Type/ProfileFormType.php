<?php
/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aml\Bundle\WebBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

/**
 * Class ProfileFormType
 *
 * @package Aml\Bundle\WebBundle\Form\Type
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
                'text',
                array(
                    'required' => false,
                )
            )
            ->add(
                'lastname',
                'text',
                array(
                    'required' => false,
                )
            )
            ->add(
                'phone',
                'text',
                array(
                    'required' => false,
                )
            )
            ->add(
                'mobile',
                'text',
                array(
                    'required' => false,
                )
            )
            ->add(
                'birthdate',
                'date',
                array(
                    'required' => false,
                )
            )
            ->add(
                'job',
                'text',
                array(
                    'required' => false,
                )
            )
            ->add(
                'adresse',
                'textarea',
                array(
                    'required' => false,
                )
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
