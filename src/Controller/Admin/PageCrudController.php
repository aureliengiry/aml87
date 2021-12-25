<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Page;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Page::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['id', 'title', 'body']);
    }

    public function configureFields(string $pageName): iterable
    {
        $title = TextField::new('title');
        $body = TextEditorField::new('body');
        $public = Field::new('public');
        $id = IntegerField::new('id', 'ID');
        $created = DateTimeField::new('created');
        $updated = DateTimeField::new('updated');
        $url = AssociationField::new('url');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $title, $created, $updated, $public, $url];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $title, $body, $created, $updated, $public, $url];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$title, $body, $public];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$title, $body, $public];
        }
    }
}
