<?php

namespace App\DataFixtures\Office;

use App\DataFixtures\ConstantesFixtures;
use App\Entity\Hub;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HubFixtures extends Fixture
{
//    private RoleRepository $roleRepository;
//
//
//    public function __construct(RoleRepository $roleRepository)
//    {
//        $this->roleRepository = $roleRepository;
//    }

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        // $roles = $this->roleRepository->findAll();

        for ($i = 0; $i < ConstantesFixtures::HUB_NB; $i++) {
            $hub = new Hub();
            $hub->setName($faker->name())
                ->setDescription($faker->sentence())
                ->setPriority($faker->numberBetween(
                    ConstantesFixtures::PRIORITY_MIN,
                    ConstantesFixtures::PRIORITY_MAX
                ))
            ;
                // ->addRole($faker->randomElement($roles));
            $manager->persist($hub);
            $manager->flush();
        }
    }
//
//    public function getDependencies(): array
//    {
//        return [
//            RoleFixtures::class
//        ];
//    }
}
