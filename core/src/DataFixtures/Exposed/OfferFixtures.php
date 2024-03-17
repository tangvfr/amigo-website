<?php

namespace App\DataFixtures\Exposed;

use App\DataFixtures\ConstantesFixtures;
use App\DataFixtures\UtilFixtures;
use App\Entity\Offer;
use App\Repository\CompanyRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Monolog\Handler\Curl\Util;

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
            $keyWords = $faker->words($faker->numberBetween(
                ConstantesFixtures::OFFER_KEY_WORDS_NB_MIN,
                ConstantesFixtures::OFFER_KEY_WORDS_NB_MAX)
            );

            $date = UtilFixtures::createDate(
                $faker,
                ConstantesFixtures::OFFER_DATE_BETWEEN_MIX,
                ConstantesFixtures::OFFER_DATE_BETWEEN_MAX,
                false
            );

            $datetime = UtilFixtures::bgeDateToDateTime($date);

            $endProvidDate = $datetime->modify(ConstantesFixtures::OFFER_GAP_END_PROVIDE_DATE);
            $publicationDate1 = $datetime->modify(ConstantesFixtures::OFFER_GAP_PUBLICATION_DATE_MIN);
            $publicationDate2 = $datetime->modify(ConstantesFixtures::OFFER_GAP_PUBLICATION_DATE_MAX);

            $offer = new Offer();
            $offer->setLabel($faker->sentence(ConstantesFixtures::NB_WORD_LABEL))
                ->setDescription($faker->sentence())
                ->setEndProvidDate($endProvidDate)
                ->setKeyWords($keyWords)
                ->setProvider($faker->randomElement($companies))
                ->setBgedDate($date)
            ;

            if ($faker->boolean(ConstantesFixtures::PUBLICATION_DATE_PROBA)) {
                $offer->setPublicationDate(UtilFixtures::randomDateBetween($publicationDate1, $publicationDate2));
            }

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
