<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des membres')
            ->setSearchFields(['username', 'usernameCanonical', 'email', 'emailCanonical', 'confirmationToken', 'roles', 'id', 'firstname', 'lastname', 'phone', 'mobile', 'adresse', 'job']);
    }

    public function configureFields(string $pageName): iterable
    {
        $username = TextField::new('username');
        $email = TextField::new('email');
        $enabled = Field::new('enabled');
        $roles = ArrayField::new('roles');
        $firstname = TextField::new('firstname');
        $lastname = TextField::new('lastname');
        $phone = TextField::new('phone');
        $mobile = TextField::new('mobile');
        $birthdate = DateTimeField::new('birthdate');
        $adresse = TextareaField::new('adresse');
        $job = TextField::new('job');
        $usernameCanonical = TextField::new('usernameCanonical');
        $emailCanonical = TextField::new('emailCanonical');
        $salt = TextField::new('salt');
        $password = TextField::new('password');
        $lastLogin = DateTimeField::new('lastLogin');
        $confirmationToken = TextField::new('confirmationToken');
        $passwordRequestedAt = DateTimeField::new('passwordRequestedAt');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$username, $email, $enabled, $lastLogin];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$username, $usernameCanonical, $email, $emailCanonical, $enabled, $salt, $password, $lastLogin, $confirmationToken, $passwordRequestedAt, $roles, $id, $firstname, $lastname, $phone, $mobile, $birthdate, $adresse, $job];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$username, $email, $enabled, $roles, $firstname, $lastname, $phone, $mobile, $birthdate, $adresse, $job];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$username, $email, $enabled, $roles, $firstname, $lastname, $phone, $mobile, $birthdate, $adresse, $job];
        }
    }
}
