<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public const ADMIN_USER = 'admin';
    public const SIMPLE_USER = 'simple-user';

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $adminUser = new User();
        $adminUser->setSuperAdmin(true);
        $adminUser->setUsername(self::ADMIN_USER);
        $adminUser->setFirstname('admin');
        $adminUser->setLastname('User');
        $adminUser->setPassword($this->passwordEncoder->encodePassword(
            $adminUser,
            'password'
        ));
        $adminUser->setEmail('admin@aml87.fr');
        $adminUser->setActive(true);

        $manager->persist($adminUser);

        $this->addReference(self::ADMIN_USER, $adminUser);

        $simpleUser = new User();
        $simpleUser->setSuperAdmin(false);
        $simpleUser->setUsername(self::SIMPLE_USER);
        $simpleUser->setFirstname('Simple');
        $simpleUser->setLastname('User');
        $simpleUser->setPassword($this->passwordEncoder->encodePassword(
            $simpleUser,
            'password'
        ));
        $simpleUser->setEmail('simple-user@aml87.fr');
        $simpleUser->setActive(true);

        $manager->persist($simpleUser);

        $this->addReference(self::SIMPLE_USER, $simpleUser);

        $manager->flush();
    }
}
