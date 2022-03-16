<?php

declare(strict_types=1);

/**
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>.
 */

namespace App\DataFixtures;

use App\Entity\Evenement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;

/**
 * Class EvenementFixtures.
 */
class EvenementFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $loader = new NativeLoader();
        $fakeData = $loader->loadFile(__DIR__.'/evenements_fixtures.yaml');
        foreach ($fakeData->getObjects() as $object) {
            if ($object instanceof Evenement) {
                /** @var Evenement $object */
                $allEventTypes = array_keys(Evenement::getTypesEvenements());
                $eventType = array_rand($allEventTypes);
                $object->setType($allEventTypes[$eventType]);
            }
            $manager->persist($object);
        }
        $manager->flush();
    }
}
