<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Media;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MediaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Media::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des médias (photos, videos..)')
            ->setSearchFields(['id', 'title']);
    }

    public function configureFields(string $pageName): iterable
    {
        $title = TextField::new('title');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $title];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $title];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$title];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$title];
        }
    }
}
