<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;

/**
 * Class DiscographyFixtures.
 */
class DiscographyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $loader = new NativeLoader();
        $fakeData = $loader->loadFile(__DIR__.'/discography_fixtures.yaml');
        foreach ($fakeData->getObjects() as $object) {
            $manager->persist($object);
        }
        $manager->flush();
    }
}
