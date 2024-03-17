<?php

namespace App\DataFixtures;

use App\Entity\Date\BeginEndDateEmbeddable;
use App\Entity\Offer;
use App\Repository\CompanyRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OfferFixtures extends Fixture implements DependentFixtureInterface
{
    private CompanyRepository $companyRepository;


    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }


    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create("fr_FR");

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

        $keyWords = array($faker->words(3));
        $companies = $this->companyRepository->findAll();

        for ($i = ConstantesFixtures::ZERO; $i < ConstantesFixtures::NBDATAMAX; $i++) {
            $offer = new Offer();
            $offer->setLabel($faker->word())
                ->setDescription($faker->sentence())
                ->setEndProvidDate($faker->dateTime())
                ->setKeyWords($keyWords)
                ->setProvide($faker->randomElement($companies))
                ->setBgedDate($date)
            ;

            $manager->persist($offer);
        }

        $manager->flush();
    }


    public function getDependencies(): array
    {
        return [
            CompanyFixtures::class
        ];
    }
}
