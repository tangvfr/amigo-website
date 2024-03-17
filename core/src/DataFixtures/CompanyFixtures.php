<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Repository\CompanyTypeRepository;
use App\Repository\LocationRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CompanyFixtures extends Fixture implements DependentFixtureInterface
{
    private LocationRepository $locationRepository;
    private CompanyTypeRepository $companyTypeRepository;

    public function __construct(
        LocationRepository $locationRepository,
        CompanyTypeRepository $companyTypeRepository)
    {
        $this->locationRepository = $locationRepository;
        $this->companyTypeRepository = $companyTypeRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create("fr_FR");

        $locations = $this->locationRepository->findAll();
        $acitivities = $this->companyTypeRepository->findAll();

        for ($i = ConstantesFixtures::ZERO; $i < ConstantesFixtures::NBDATAMAX; $i++) {
            $company = new Company();
            $company->setName($faker->name())
                ->setDescription($faker->sentence());

            for ($i = ConstantesFixtures::ZERO;
                 $i < $faker->numberBetween(ConstantesFixtures::ONE,ConstantesFixtures::TWO);
                 $i++) {
                $company->addLocated($faker->randomElement($locations))
                    ->addActivity($faker->randomElement($acitivities));
            }

            $manager->persist($company);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            LocationFixtures::class,
            CompanyTypeFixtures::class
        ];
    }
}
