<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;

/**
 * Class DiscographyFixtures
 * @package App\DataFixtures
 */
class DiscographyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $loader = new NativeLoader();
        $fakeData = $loader->loadFile(__DIR__ . '/discography_fixtures.yaml');
        foreach ($fakeData->getObjects() as $object){
            $manager->persist($object);
        }
        $manager->flush();
    }
}
