<?php
namespace Aml\Bundle\BlogBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class BlogAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
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
                'property_path' => false
            ))
            ->add('tags', 'hidden', array(
                'property_path' => false
            ))

            ->add('public','checkbox',array(
                'label' => 'Publier',
                'required' => false,
                'attr' => array('data-help' => 'Signifie que l\'article sera visible pour tout le monde'),
            ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('created')
            ->add('public')
        ;
    }

    /**
     * @param string $name
     *
     * @return null|string
     */
    public function getTemplate($name)
    {
        var_dump( $name );
        if (isset($this->templates[$name])) {
            return $this->templates[$name];
        }

        return null;
    }
}