<?php

namespace App\DataFixtures;

use App\Entity\Date\BeginEndDateEmbeddable;
use App\Entity\Partner;
use App\Repository\CompanyRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PartnerFixtures extends Fixture implements DependentFixtureInterface
{
    private const CHANCEOFCHALLENGE = 66;

    public function __construct(
        private readonly CompanyRepository $companyRepository
    ){}

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create("fr_FR");

        $companies = $this->companyRepository->findAll();

        $date1 = $faker->dateTime();
        $date2 = $faker->dateTime();
        $date = new BeginEndDateEmbeddable();
        if ($date1 < $date2)
        {
            $date->setBeginDate($date1)
                ->setEndDate($date2);
        } else
        {
            $date->setBeginDate($date2)
                ->setEndDate($date1);
        }

        for ($i = 0; $i < ConstantesFixtures::NB_DATA_MAX; $i++) {
            $partner = new Partner();
            $partner->setCompany($faker->randomElement($companies))
                ->setChallenge($faker->boolean(self::CHANCEOFCHALLENGE))
                ->setAdvantages($faker->sentence())
                ->setBgedDate($date)
            ;

            $manager->persist($partner);
            $manager->flush();
        }
    }

    public function getDependencies(): array
    {
        return [
            CompanyFixtures::class
        ];
    }
}
