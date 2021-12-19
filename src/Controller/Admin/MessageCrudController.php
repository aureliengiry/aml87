<?php

namespace App\Controller\Admin;

use App\Entity\Message;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MessageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Message::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des messages reçus par le formulaire de contact')
            ->setSearchFields(['id', 'name', 'email', 'subject', 'body', 'addressIp', 'status']);
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('name');
        $email = TextField::new('email');
        $subject = TextField::new('subject');
        $body = TextareaField::new('body');
        $addressIp = TextField::new('addressIp');
        $status = IntegerField::new('status');
        $created = DateTimeField::new('created');
        $spam = Field::new('spam');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $email, $subject, $addressIp, $status, $created];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $name, $email, $subject, $body, $addressIp, $status, $created, $spam];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name, $email, $subject, $body, $addressIp, $status, $created, $spam];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $email, $subject, $body, $addressIp, $status, $created, $spam];
        }
    }
}
