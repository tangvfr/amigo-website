<?php

namespace App\DataFixtures;

use App\Entity\Date\BeginEndDateEmbeddable;
use App\Entity\Mandate;
use App\Repository\RoleRepository;
use App\Repository\StudentRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MandateFixtures extends Fixture implements DependentFixtureInterface
{
    private RoleRepository $roleRepository;
    private StudentRepository $studentRepository;

    public function __construct(
        RoleRepository $roleRepository,
        StudentRepository $studentRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->studentRepository = $studentRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create("fr_FR");

        $roles = $this->roleRepository->findAll();
        $students = $this->studentRepository->findAll();

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

        for ($i = 0; $i < ConstantesFixtures::NB_DATA_MAX; $i++) {
            $mandate = new Mandate();
            $mandate->addRole($faker->randomElement($roles))
                ->setStudent($faker->randomElement($students))
                ->setVisible($faker->boolean())
                ->setBgedDate($date)
            ;

            $manager->persist($mandate);
            $manager->flush();
        }
    }


    public function getDependencies(): array
    {
        return [
            RoleFixtures::class,
            StudentFixtures::class
        ];
    }
}
