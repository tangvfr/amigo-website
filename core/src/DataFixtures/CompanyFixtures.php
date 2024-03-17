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
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);

        $faker = \Faker\Factory::create('fr_FR');

        $locations = $this->locationRepository->findAll();
        $acitivities = $this->companyTypeRepository->findAll();

        for ($i = 0; $i < 4; $i++) {
            $company = new Company();
            $company->setName($faker->colorName(). ' ' .$faker->domainWord(). ' ' .$faker->firstName())
                ->setDescription($faker->sentence());

            $nbLoc = $faker->randomElement([1,1,1,1,2,2,3]);
            for ($i = 0; $i < $nbLoc; $i++) {
                $company->addLocated($faker->randomElement($locations));
            }

            $nbAct = $faker->numberBetween(1,3);
            for ($i = 0; $i < $nbAct; $i++) {
                $company->addActivity($faker->randomElement($acitivities));
            }

            $manager->persist($company);
            $manager->flush();
            //$manager->clear();
        }
    }

    public function getDependencies(): array
    {
        return [
            LocationFixtures::class,
            CompanyTypeFixtures::class
        ];
    }
}
