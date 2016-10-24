<?php
namespace Aml\Bundle\ContactUsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Class MessageType
 *
 * @package Aml\Bundle\ContactUsBundle\Form\Type
 */
class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('email')
            ->add('subject')
            ->add(
                'body',
                TextareaType::class,
                array(
                    'attr' => array('size' => 15, 'data-help' => 'Texte de l\'article'),
                    'required' => false,
                )
            )
            ->add('spam', TextType::class, array(
                'required' => false,
                'attr' => array('style' => 'display:none')
            ))
            ->add(
                'send',
                SubmitType::class,
                array(
                    'attr' => array('class' => 'btn btn-primary pull-right'),
                )
            );
    }

    public function getName()
    {
        return 'aml_bundle_ContactUsBundle_messagetype';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            // Ici, une clé unique par formulaire pour la génération du jeton CSRF
            'intention' => 'aml_user_profile_form',
        ));
    }
}
