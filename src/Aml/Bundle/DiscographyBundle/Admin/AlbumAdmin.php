<?php
namespace Aml\Bundle\DiscographyBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class AlbumAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('title','text',array(
                    'label' => 'Titre'
                ))
                ->add('image','sonata_type_admin')
                ->add('description', 'textarea', array(
                    'label' => 'Texte',
                    'attr' => array('size' => 15, 'data-help' => 'Description de l\'album'),
                    'required' => false,
                    'wysiwyg' => true
                ))
                ->add('date', 'date', array(
                    'label' => 'Date de sortie',
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                  // 'attr' => array('readonly' => 'readonly')
                ))
                ->add('public','checkbox',array(
                    'label' => 'Publier',
                    'required' => false,
                    'attr' => array('data-help' => 'Signifie que l\'album sera visible pour tout le monde'),
                ))
            ->end()
            ->with('Tracks')
                ->add('tracks', 'textarea', array(
                    'label' => 'Pistes',
                    'attr' => array('size' => 15, 'data-help' => 'Liste des morceaux de l\'album'),
                    'required' => false,
                    'wysiwyg' => true
                ))
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('public')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('date')
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
        if (isset($this->templates[$name])) {
            return $this->templates[$name];
        }

        return null;
    }
}