<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\AdminType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PartenaireAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Nom',
                ]
            )
            ->add(
                'logo',
                AdminType::class,
                [
                    'delete' => false,
                    'required' => false,
                ]
            )
            ->add('url')
            ->add(
                'description',
                TextareaType::class,
                [
                    'required' => false,
                ]
            );
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('url');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('url');
    }

    public function preUpdate($partenaire)
    {
        $this->setLogoTitle($partenaire);
    }

    protected function setLogoTitle($partenaire)
    {
        $logo = $partenaire->getLogo();

        $logo->setTitle($partenaire->getName());

        // Remove old file
        $logo->storeFilenameForRemove();
        $logo->removeUpload();

        // Upload
        $logo->preUpload();
    }
}
