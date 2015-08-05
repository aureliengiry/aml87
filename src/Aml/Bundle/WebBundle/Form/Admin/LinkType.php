<?php

namespace Aml\Bundle\WebBundle\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                'text',
                array(
                    'label' => 'Titre'
                )
            )
            ->add(
                'url',
                'text',
                array(
                    'label' => 'URL'
                )
            )
            ->add(
                'public',
                'checkbox',
                array(
                    'label' => 'Statut',
                    'required' => false,
                    'attr' => array('data-help' => 'Signifie que la formation n\'a pas lieu dans les locaux d\'Idéal Connaissances'),
                )
            );

//            $builder->add('captcha', 'captcha', array(
//         'width' => 200,
//         'height' => 50,
//         'length' => 6,
//     ));
    }

    public function getName()
    {
        return 'aml_bundle_WebBundle_linktype';
    }
}
