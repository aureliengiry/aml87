<?php
namespace App\Admin;

use App\Entity\Album;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class TrackAdmin
 * @package App\Admin
 */
class TrackAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
            ->add(
                'title',
                TextType::class,
                [
                    'label' => 'Titre',
                ]
            )
            ->add(
                'composer',
                TextType::class,
                [
                    'label' => 'Compositeur',
                ]
            )
            ->add(
                'number',
                TextType::class,
                [
                    'label' => 'Piset N°',
                ]
            )
            ->add(
                'album',
                EntityType::class,
                [
                    'label'        => 'Album',
                    'class'        => Album::class,
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
}
