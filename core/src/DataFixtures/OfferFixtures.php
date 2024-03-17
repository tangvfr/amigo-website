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
        $faker = \Faker\Factory::create('fr_FR');

        $companies = $this->companyRepository->findAll();

        for ($i = 0; $i < ConstantesFixtures::OFFER_NB; $i++)
        {
            $keyWords = $faker->words($faker->numberBetween(1,10));

            $date = UtilFixtures::createDate(
                $faker,
                ConstantesFixtures::OFFER_DATE_BETWEEN_MIX,
                ConstantesFixtures::OFFER_DATE_BETWEEN_MAX,
                false
            );

            $endProvidDate = new \DateTime();
            $endProvidDate->setDate(
                $date->getEndDate()->format('Y'),
                $date->getEndDate()->format('m'),
                $date->getEndDate()->format('d')
            );
            $endProvidDate->modify('-2 weeks');

            $offer = new Offer();
            $offer->setLabel($faker->sentence(ConstantesFixtures::NB_WORD_LABEL))
                ->setDescription($faker->sentence())
                ->setEndProvidDate($faker->dateTime())
                ->setEndProvidDate($endProvidDate)
                ->setKeyWords($keyWords)
                ->setProvider($faker->randomElement($companies))
                ->setBgedDate($date)
            ;

            $manager->persist($offer);
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
