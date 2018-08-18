<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Admin;

use App\Entity\UrlPage;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class PageAdmin.
 */
class PageAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add(
                'title',
                TextType::class,
                [
                    'label' => 'Titre',
                ]
            )
            ->add(
                'body',
                CKEditorType::class,
                [
                    'required' => false,
                    'config_name' => 'aml_config',
                ]
            )
            ->add(
                'public',
                CheckboxType::class,
                [
                    'label' => 'Publier',
                    'required' => false,
                    'attr' => ['data-help' => 'Signifie que la page sera visible pour tout le monde'],
                ]
            );
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('url')
            ->add('public');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('url')
            ->add('created')
            ->add('updated')
            ->add('public');
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($page)
    {
        $page->setUpdated(new \DateTime());

        $urlKey = $page->getUrl();
        if (empty($urlKey)) {
            $entityUrl = new UrlPage();
            $entityUrl->setUrlKey($page->getTitle());

            $page->setUrl($entityUrl);
        } else {
            $urlKey->setUrlKey($page->getTitle());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($page)
    {
        $entityUrl = new UrlPage();
        $entityUrl->setUrlKey($page->getTitle());

        $page
            ->setCreated(new \DateTime())
            ->setUpdated(new \DateTime())
            ->setUrl($entityUrl);
    }
}
