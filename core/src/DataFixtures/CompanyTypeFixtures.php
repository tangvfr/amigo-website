<?php

namespace App\DataFixtures;

use App\Entity\CompanyType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CompanyTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create("fr_FR");

        for ($i = ConstantesFixtures::ZERO; $i < ConstantesFixtures::NBDATAMAX; $i++) {
            $companyType = new CompanyType();
            $companyType->setLabel($faker->name());

            $manager->persist($companyType);
        }
        $manager->flush();
    }
}
