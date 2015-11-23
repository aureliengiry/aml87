<?php
namespace Aml\Bundle\DiscographyBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class TrackAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
            ->add(
                'title',
                'text',
                array(
                    'label' => 'Titre'
                )
            )
            ->add(
                'composer',
                'text',
                array(
                    'label' => 'Compositeur'
                )
            )
            ->add(
                'number',
                'text',
                array(
                    'label' => 'Piset N°'
                )
            )
            ->add(
                'album',
                'entity',
                array(
                    'label' => 'Album',
                    'class' => 'AmlDiscographyBundle:Album',
                    'choice_label' => 'title',
                    'placeholder' => 'Choisissez un album',
                    'attr' => array('class' => 'uniform')
                )
            )
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('album')
            ->add('title')
            ->add('composer');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('album')
            ->addIdentifier('title')
            ->add('composer');
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