<?php
namespace Aml\Bundle\WebBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class AlbumAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title','text',array(
                'label' => 'Titre'
            ))
            ->add('logo',new ImageType() , array(
                'required' => false,
            ) )
            ->add('description')
            ->add('date', 'date', array(
                'label' => 'Date de sortie',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'required' => false,
              // 'attr' => array('readonly' => 'readonly')
            ))
            ->add('titres')
            ->add('public','checkbox',array(
                'label' => 'Publier',
                'required' => false,
                'attr' => array('data-help' => 'Signifie que l\'album sera visible pour tout le monde'),
            ))
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