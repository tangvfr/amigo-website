<?php

namespace App\DataFixtures\Exposed;

use App\DataFixtures\ConstantesFixtures;
use App\DataFixtures\UtilFixtures;
use App\Entity\Partner;
use App\Repository\CompanyRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PartnerFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private readonly CompanyRepository $companyRepository
    ){}

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $companies = $this->companyRepository->findAll();

        for ($i = 0; $i < ConstantesFixtures::PARTNER_NB; $i++)
        {
            $date = UtilFixtures::createDate(
                $faker,
                ConstantesFixtures::PARTNER_DATE_BETWEEN_MIN,
                ConstantesFixtures::PARTNER_DATE_BETWEEN_MAX,
                false
            );

            $datetime = UtilFixtures::bgeDateToDateTime($date);

            $publicationDate1 = $datetime->modify(ConstantesFixtures::PARTNER_GAP_PUBLICATION_DATE);

            $partner = new Partner();
            $partner->setCompany($faker->randomElement($companies))
                ->setChallenge($faker->boolean(ConstantesFixtures::CHALLENGE_PROBA))
                ->setAdvantages($faker->sentence())
                ->setBgedDate($date)
            ;

            if ($faker->boolean(ConstantesFixtures::PUBLICATION_DATE_PROBA)) {
                $partner->setPublicationDate(UtilFixtures::randomDateBetween($publicationDate1, $date->getEndDate()));
            }

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
