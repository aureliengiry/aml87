<?php

namespace App\Controller\Admin;

use App\Entity\Evenement;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EvenementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Evenement::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des évènements')
            ->setSearchFields(['id', 'type', 'title', 'description']);
    }

    public function configureFields(string $pageName): iterable
    {
        $panel1 = FormField::addPanel('Basic Information');
        $type = TextField::new('type');
        $title = TextField::new('title');
        $description = TextEditorField::new('description');
        $dateStart = DateTimeField::new('dateStart');
        $dateEnd = DateTimeField::new('dateEnd');
        $season = AssociationField::new('season');
        $public = Field::new('public');
        $archive = Field::new('archive');
        $panel2 = FormField::addPanel('Contenus liés à cet évenement');
        $articles = AssociationField::new('articles');
        $partenaires = AssociationField::new('partenaires');
        $videos = AssociationField::new('videos');
        $id = IntegerField::new('id', 'ID');
        $picture = AssociationField::new('picture');
        $url = AssociationField::new('url');
        $getDates = TextareaField::new('getDates');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$title, $type, $getDates, $season, $public, $archive];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $type, $dateStart, $dateEnd, $title, $description, $archive, $public, $picture, $articles, $partenaires, $url, $season, $videos];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$panel1, $type, $title, $description, $dateStart, $dateEnd, $season, $public, $archive, $panel2, $articles, $partenaires, $videos];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$panel1, $type, $title, $description, $dateStart, $dateEnd, $season, $public, $archive, $panel2, $articles, $partenaires, $videos];
        }
    }
}
