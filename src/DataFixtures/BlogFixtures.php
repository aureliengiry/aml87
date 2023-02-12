<?php

declare(strict_types=1);

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;

/**
 * Class BlogFixtures.
 */
class BlogFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $loader = new NativeLoader();
        $fakeData = $loader->loadFile(__DIR__.'/blog_fixtures.yaml');
        foreach ($fakeData->getObjects() as $object) {
            $manager->persist($object);
        }

        $manager->flush();
    }
}
