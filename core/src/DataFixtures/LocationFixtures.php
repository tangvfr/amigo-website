<?php

namespace App\DataFixtures;

use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LocationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create("fr_FR");
        for ($i = 0; $i < 10; $i++) {
            $location = new Location();
            $location->setLabel($faker->sentence(3));

            if ($faker->boolean(50))
            {
                $location->setCountry($faker->country())
                    ->setCity($faker->city())
                    ->setPostalCode($faker->postcode())
                    ->setAdresse($faker->address());
            } else
            {
                $location->setLongitude($faker->longitude())
                    ->setLatitude($faker->latitude());
            }

            $manager->persist($location);
            $manager->flush();
        }
    }
}
