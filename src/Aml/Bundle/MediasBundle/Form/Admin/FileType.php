<?php
namespace Aml\Bundle\MediasBundle\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\CallbackValidator;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormError;

class FileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                'text',
                array(
                    'label' => 'Titre',
                    'attr' => array('placeholder' => 'Saisir le titre')
                )
            )
            ->add(
                'file',
                'file',
                array(
                    'label' => 'Fichier'
                )
            );
    }

    public function getName()
    {
        return 'aml_bundle_webbundle_admin_filetype';
    }
}
