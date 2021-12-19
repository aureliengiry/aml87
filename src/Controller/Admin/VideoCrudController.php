<?php

namespace App\Controller\Admin;

use App\Entity\Video\Youtube;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class VideoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Youtube::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des Vidéos')
            ->setSearchFields(['id', 'providerId', 'title']);
    }

    public function configureFields(string $pageName): iterable
    {
        $providerId = TextField::new('providerId');
        $title = TextField::new('title');
        $evenements = AssociationField::new('evenements');
        $id = IntegerField::new('id', 'ID');
        $urlThumbnail = ImageField::new('urlThumbnail');
        $urlYoutube = UrlField::new('urlYoutube', 'URL Youtube');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$urlThumbnail, $title, $urlYoutube];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $providerId, $title, $evenements];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$providerId, $title, $evenements];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$providerId, $title, $evenements];
        }
    }
}
