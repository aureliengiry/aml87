<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des articles du blog')
            ->setSearchFields(['id', 'title', 'body']);
    }

    public function configureFields(string $pageName): iterable
    {
        $panel1 = FormField::addPanel('Basic Information');
        $title = TextField::new('title');
        $body = TextEditorField::new('body');
        $public = Field::new('public');
        $category = AssociationField::new('category');
        $tags = AssociationField::new('tags');
        $panel2 = FormField::addPanel('Medias');
//        $logo = ImageField::new('logo')->setUploadDir('public/uploads/images');
        $logo = AssociationField::new('logo')->renderAsNativeWidget();
        $video = AssociationField::new('video');
        $published = DateTimeField::new('published');
        $url = UrlField::new('url', 'url');
        $evenements = AssociationField::new('evenements');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$title, $url, $public];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$title, $body, $published, $public, $url, $logo, $video, $category, $tags, $evenements];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$panel1, $title, $body, $public, $category, $tags, $panel2, $logo, $video];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$panel1, $title, $body, $public, $category, $tags, $panel2, $logo, $video];
        }
    }
}
