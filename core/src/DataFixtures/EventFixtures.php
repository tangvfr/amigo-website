<?php

namespace App\DataFixtures;

use App\Entity\Date\BeginEndDateTimeEmbeddable;
use App\Entity\Event;
use App\Repository\EventTypeRepository;
use App\Repository\LocationRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EventFixtures extends Fixture implements DependentFixtureInterface
{
    private EventTypeRepository $eventTypeRepository;
    private LocationRepository $locationRepository;


    public function __construct(
        EventTypeRepository $eventTypeRepository,
        LocationRepository $locationRepository)
    {
        $this->eventTypeRepository = $eventTypeRepository;
        $this->locationRepository = $locationRepository;
    }


    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $eventTypes = $this->eventTypeRepository->findAll();
        $locations = $this->locationRepository->findAll();

        for ($i = 0; $i < ConstantesFixtures::EVENT_NB; $i++)
        {
            $date = UtilFixtures::createDate(
                $faker,
                ConstantesFixtures::EVENT_DATE_BETWEEN_MIN,
                ConstantesFixtures::EVENT_DATE_BETWEEN_MAX,
                true
            );

            $event = new Event();
            $event->setName($faker->sentence(ConstantesFixtures::NB_WORD_LABEL))
                ->setDescription($faker->sentence());

            $event->setOnlyMiagist($faker->boolean(ConstantesFixtures::PROBA_ONLY_MIAGIST));

            $event->setNadhPrice($faker->numberBetween(
                    0,
                    ConstantesFixtures::PRICE_EVENT_NADH_MAX
                ))
                ->setAdhPrice($event->getNadhPrice()-ConstantesFixtures::DIFF_PRICE_NADH_ADH)
                ->setQuotaStu($faker->numberBetween(
                    ConstantesFixtures::QUOTA_STU_MIN,
                    ConstantesFixtures::QUOTA_MAX
                ))
                ->setQuotaComp($faker->numberBetween(
                    0,
                    ConstantesFixtures::QUOTA_MAX
                ))
                ->setNote($faker->numberBetween(
                    0,
                    ConstantesFixtures::NOTE_MAX
                ))
                ->addType($faker->randomElement($eventTypes));

            if ($faker->boolean(ConstantesFixtures::TWO_TYPES_PROBA))
            {
                $event->addType($faker->randomElement($eventTypes));
            }

            $event->addSituated($faker->randomElement($locations))
                ->setBgedDate($date);

            $event->setCancel($faker->boolean(ConstantesFixtures::EVENT_CANCEL_PROBA));

            $manager->persist($event);
            $manager->flush();
        }
    }

    public function getDependencies(): array
    {
        return [
            EventTypeFixtures::class,
            LocationFixtures::class
        ];
    }
}
