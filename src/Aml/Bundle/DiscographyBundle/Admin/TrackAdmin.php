<?php
namespace Aml\Bundle\DiscographyBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class TrackAdmin
 * @package Aml\Bundle\DiscographyBundle\Admin
 */
class TrackAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
            ->add(
                'title',
                'text',
                [
                    'label' => 'Titre',
                ]
            )
            ->add(
                'composer',
                'text',
                [
                    'label' => 'Compositeur',
                ]
            )
            ->add(
                'number',
                'text',
                [
                    'label' => 'Piset N°',
                ]
            )
            ->add(
                'album',
                'entity',
                [
                    'label'        => 'Album',
                    'class'        => 'AmlDiscographyBundle:Album',
                    'choice_label' => 'title',
                    'placeholder'  => 'Choisissez un album',
                    'attr'         => ['class' => 'uniform'],
                ]
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
