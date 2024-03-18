<?php

namespace App\DataFixtures\Office;

use App\DataFixtures\ConstantesFixtures;
use App\DataFixtures\Exposed\StudentFixtures;
use App\DataFixtures\UtilFixtures;
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
        $faker = \Faker\Factory::create('fr_FR');

        $roles = $this->roleRepository->findAll();
        $students = $this->studentRepository->findAll();

        for ($i = 0; $i < ConstantesFixtures::MANDATE_NB; $i++) {

            $date = UtilFixtures::createDate(
                $faker,
                ConstantesFixtures::MANDATE_DATE_BETWEEN_MIN,
                ConstantesFixtures::MANDATE_DATE_BETWEEN_MAX,
                false
            );

            $mandate = new Mandate();
            $mandate->addRole($faker->randomElement($roles))
                ->setStudent($faker->randomElement($students))
                ->setVisible($faker->boolean(ConstantesFixtures::VISIBLE_PROBA))
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
