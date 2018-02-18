<?php

namespace Aml\Bundle\WebBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;

/**
 * Class LoadBlogFixtures
 * @package Aml\Bundle\WebBundle\DataFixtures\ORM
 */
class LoadBlogFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $loader = new NativeLoader();
        $fakeData = $loader->loadFile(__DIR__ . '/blog_fixtures.yml');
        foreach ($fakeData->getObjects() as $object){
            $manager->persist($object);
        }
        $manager->flush();
    }
}
