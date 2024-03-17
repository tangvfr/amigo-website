<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Repository\HubRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture implements DependentFixtureInterface
{
    private HubRepository $hubRepository;


    public function __construct(HubRepository $hubRepository)
    {
        $this->hubRepository = $hubRepository;
    }


    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create("fr_FR");

        $hubs = $this->hubRepository->findAll();

        for ($i = 0; $i < ConstantesFixtures::NB_DATA_MAX; $i++) {
            $role = new Role();
            $role->setHub($faker->randomElement($hubs))
                ->setName($faker->word())
                ->setHub($faker->randomElement($hubs))
                ->setPriority($faker->numberBetween(-10,10))
            ;

            $manager->persist($role);
            $manager->flush();
        }
    }

    public function getDependencies(): array
    {
        return [
            HubFixtures::class
        ];
    }
}
