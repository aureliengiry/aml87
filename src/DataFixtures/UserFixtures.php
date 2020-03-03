<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    const ADMIN_USER = 'admin';
    const SIMPLE_USER = 'simple-user';

    public function load(ObjectManager $manager)
    {
        $adminUser = new User();
        $adminUser->setSuperAdmin(true);
        $adminUser->setUsername(self::ADMIN_USER);
        $adminUser->setFirstname('Admin');
        $adminUser->setLastname('User');
        $adminUser->setPlainPassword('password');
        $adminUser->setEmail('admin@aml87.fr');
        $adminUser->setEnabled(true);

        $manager->persist($adminUser);

        $this->setReference(self::ADMIN_USER, $adminUser);

        $simpleUser = new User();
        $simpleUser->setSuperAdmin(false);
        $simpleUser->setUsername(self::SIMPLE_USER);
        $simpleUser->setFirstname('Simple');
        $simpleUser->setLastname('User');
        $simpleUser->setPlainPassword('password');
        $simpleUser->setEmail('simple-user@aml87.fr');
        $simpleUser->setEnabled(true);

        $manager->persist($simpleUser);

        $this->setReference(self::SIMPLE_USER, $simpleUser);

        $manager->flush();
    }
}
