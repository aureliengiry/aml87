<?php
namespace Aml\Bundle\BlogBundle\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\CallbackValidator;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormError;

class BlogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('body','textarea', array(
            	'label' => 'Texte',
            	'attr' => array('size' => 15, 'data-help' => 'Texte de l\'article'),
            	'required' => false,
            ))
            ->add('category','entity',array(
                'label' => 'Catégorie',
                'class' => 'AmlBlogBundle:BlogCategories',
                'property' => 'name',
                'empty_value' => 'Choisissez une catégorie',
            ))

            ->add('addtags', 'genemu_jqueryautocompleter_entity', array(
                'route_name' => 'blog_tags_ajax_autocomplete',
                'class' => 'Aml\Bundle\BlogBundle\Entity\BlogTags',
                'property' => 'name',
                'label' => 'Tags',
                'attr' => array(
                    'placeholder' => 'Ajouter des tags',
                ),
                'required' => false,
                'mapped' => false
            ))
            ->add('tags', 'hidden', array(
                'mapped' => false
            ))

            ->add('public','checkbox',array(
            	'label' => 'Publier',
            	'required' => false,
            	'attr' => array('data-help' => 'Signifie que l\'article sera visible pour tout le monde'),
            ))
        ;
    }

    public function getName()
    {
        return 'aml_bundle_BlogBundle_blogtype';
    }
}
