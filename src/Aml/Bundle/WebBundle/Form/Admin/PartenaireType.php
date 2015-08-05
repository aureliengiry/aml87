<?php

namespace Aml\Bundle\WebBundle\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Aml\Bundle\MediasBundle\Form\Admin\ImageType;

class PartenaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /**
         * ->add('title','text',array(
         * 'label' => 'Titre',
         * 'attr' => array('placeholder' => 'Saisir le titre')
         * ))
         */
        $builder
            ->add('name')
            ->add('url')
            ->add(
                'logo',
                new ImageType(),
                array()
            )
            ->add(
                'description',
                'textarea',
                array(
                    'required' => false
                )
            )
            // ->add('description')
            //->add('evenements')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Aml\Bundle\WebBundle\Entity\Partenaire',
                'cascade_validation' => true,
            )
        );
    }

    public function getName()
    {
        return 'aml_bundle_webbundle_partenairetype';
    }
}
