<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Admin;

use App\Entity\Category;
use App\Entity\UrlArticle;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\AdminType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class ArticleAdmin.
 *
 * @author      Aurélien GIRY <aurelien.giry@gmail.com>
 */
class ArticleAdmin extends AbstractAdmin
{
    // setup the default sort column and order
    protected $datagridValues = [
        '_sort_order' => 'DESC',
        '_sort_by' => 'id',
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
            ->add('title', TextType::class)
            ->add(
                'category',
                EntityType::class,
                [
                    'label' => 'Catégorie',
                    'class' => Category::class,
                    'choice_label' => 'name',
                    'placeholder' => 'Choisissez une catégorie',
                    'attr' => ['class' => 'uniform'],
                ]
            )
            ->add(
                'body',
                CKEditorType::class,
                [
                    'label' => 'Texte',
                    'required' => false,
                    'attr' => ['size' => 15, 'data-help' => 'Texte de l\'article'],
                    'config_name' => 'aml_config',
                ]
            )
            ->add(
                'public',
                CheckboxType::class,
                [
                    'label' => 'Publier',
                    'required' => false,
                    'attr' => ['data-help' => 'Signifie que l\'article sera visible pour tout le monde'],
                ]
            )
            ->end()
            ->with('Image')
            ->add(
                'logo',
                AdminType::class,
                [
                    'delete' => false,
                    'required' => false,
                ]
            )
            ->end()
            ->with('Tags')
            ->add(
                'tags',
                ModelType::class,
                [
                    'required' => false,
                    'expanded' => false,
                    'multiple' => true,
                    'by_reference' => false,
                    'attr' => ['data-sonata-select2' => 'true'],
                ]
            )
            ->end()
            ->with('Evenements')
            ->add(
                'evenements',
                ModelType::class,
                [
                    'required' => false,
                    'expanded' => true,
                    'multiple' => true,
                    'by_reference' => false,
                ]
            )
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('category')
            ->add('public');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('created')
            ->add('updated')
            ->add('category')
            ->add('public');
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($article)
    {
        $article->setUpdated(new \DateTime());

        $urlKey = $article->getUrl();
        if (empty($urlKey)) {
            $entityUrl = new UrlArticle();
            $entityUrl->setUrlKey($article->getTitle());

            $article->setUrl($entityUrl);
        } else {
            $urlKey->setUrlKey($article->getTitle());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($article)
    {
        $entityUrl = new UrlArticle();
        $entityUrl->setUrlKey($article->getTitle());

        $article
            ->setCreated(new \DateTime())
            ->setUpdated(new \DateTime())
            ->setUrl($entityUrl);
    }
}
