<?php

namespace App\DataFixtures;

use App\Entity\EventType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EventTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create("fr_FR");
        for ($i = 0; $i < 10; $i++) {
            $eventType = new EventType();
            $eventType->setLabel($faker->word())
                ->setDescription($faker->sentence());

            $manager->persist($eventType);
        }
        $manager->flush();
    }
}
