<?php

namespace App\DataFixtures;

use App\Entity\Student;
use App\Entity\StudentType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class StudentFixtures extends Fixture
{
    private ConstantesFixtures $constantesF;
    private const STUDENTNUMBERMIN = 10000000;
    private const STUDENTNUMBERMAX = 99999999;


    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create("fr_FR");
        $studentTypes = ["l3","m1","m2","wk","oth"];
        for ($i = ConstantesFixtures::ZERO; $i < ConstantesFixtures::NBDATAMAX; $i++) {
            $student = new Student();
            $student->setName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setStudentNumber($faker->numberBetween(self::STUDENTNUMBERMIN, self::STUDENTNUMBERMAX))
                ->setEmail($faker->email())
                ->setLevel(StudentType::M1)
            //    ->setLevel($faker->randomElement($studentTypes))
            ;

            $manager->persist($student);
        }
        $manager->flush();
    }
}
