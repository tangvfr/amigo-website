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
        $faker = \Faker\Factory::create("fr_FR");

        $eventTypes = $this->eventTypeRepository->findAll();
        $locations = $this->locationRepository->findAll();

        $date1 = $faker->dateTime();
        $date2 = $faker->dateTime();
        $date = new BeginEndDateTimeEmbeddable();
        if ($date1 < $date2)
        {
            $date->setBeginDate($date1)
                ->setEndDate($date2);
        } else
        {
            $date->setBeginDate($date2)
                ->setEndDate($date1);
        }

        for ($i = ConstantesFixtures::ZERO; $i < ConstantesFixtures::NBDATAMAX; $i++) {
            $event = new Event();
            $event->setName($faker->sentence(2))
                ->setDescription($faker->sentence());

            if ($faker->boolean(80)) {
                $event->setOnlyMiagist(true);
            }

            $event->setNadhPrice($faker->numberBetween(
                    ConstantesFixtures::ZERO,
                    ConstantesFixtures::PRICEEVENTNADHMAX
                ))
                ->setAdhPrice($event->getNadhPrice()-ConstantesFixtures::DIFFPRICENADHADH)
                ->setQuotaStu($faker->numberBetween(
                    ConstantesFixtures::QUOTASTUMIN,
                    ConstantesFixtures::QUOTAMAX
                ))
                ->setQuotaComp($faker->numberBetween(
                    ConstantesFixtures::ZERO,
                    ConstantesFixtures::QUOTAMAX
                ))
                ->setNote($faker->numberBetween(
                    ConstantesFixtures::ZERO,
                    ConstantesFixtures::NOTEMAX
                ))
                ->addType($faker->randomElement($eventTypes));

            if ($faker->boolean(30))
            {
                $event->addType($faker->randomElement($eventTypes));
            }

            $event->addSituated($faker->randomElement($locations))
                ->setBgedDate($date);

            if ($faker->boolean(50)) //pour simuler les events finis
            {
                $event->setCancel(true);
            }

            $manager->persist($event);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            EventTypeFixtures::class,
            LocationFixtures::class
        ];
    }
}
