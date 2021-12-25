<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('body')
            ->add('created')
            ->add('updated')
            ->add('published')
            ->add('public')
            ->add('url')
            ->add('logo')
            ->add('video')
            ->add('category')
            ->add('tags', CollectionType::class, [
                'entry_type' => TagEmbeddedForm::class,
                'allow_delete' => true,
                'allow_add' => true,
                'by_reference' => false,
            ])
            ->add('evenements');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
