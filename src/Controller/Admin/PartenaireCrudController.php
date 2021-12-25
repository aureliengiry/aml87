<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Partenaire;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PartenaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Partenaire::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['id', 'name', 'url', 'description']);
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('name');
        $url = TextField::new('url');
        $description = TextareaField::new('description');
        $logo = AssociationField::new('logo');
        $evenements = AssociationField::new('evenements');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $url, $logo, $evenements];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $name, $url, $description, $logo, $evenements];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name, $url, $description, $logo, $evenements];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $url, $description, $logo, $evenements];
        }
    }
}
