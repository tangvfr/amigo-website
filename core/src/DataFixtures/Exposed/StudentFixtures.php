<?php

namespace App\DataFixtures\Exposed;

use App\DataFixtures\ConstantesFixtures;
use App\Entity\Student;
use App\Entity\StudentType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class StudentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');
        $studentTypes = StudentType::cases();

        for ($i = 0; $i < ConstantesFixtures::STUDENT_NB; $i++) {
            $student = new Student();
            $student->setName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setStudentNumber($faker->numberBetween(
                    ConstantesFixtures::STUDENT_NUMBER_MIN,
                    ConstantesFixtures::STUDENT_NUMBER_MAX
                ))
                ->setEmail($faker->email())
            //    ->setLevel(StudentType::M1)
                ->setLevel($faker->randomElement($studentTypes))
            ;

            $manager->persist($student);
        }
        $manager->flush();
    }
}
