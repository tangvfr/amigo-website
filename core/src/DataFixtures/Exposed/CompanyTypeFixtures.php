<?php

namespace App\DataFixtures\Exposed;

use App\DataFixtures\ConstantesFixtures;
use App\Entity\CompanyType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CompanyTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < ConstantesFixtures::COMPANY_TYPE_NB; $i++) {
            $companyType = new CompanyType();
            $companyType->setLabel($faker->sentence(ConstantesFixtures::NB_WORD_LABEL));

            $manager->persist($companyType);
        }
        $manager->flush();
    }
}
