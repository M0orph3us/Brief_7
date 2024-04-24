<?php

namespace App\DataFixtures;

use App\Entity\Conditions;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ConditionsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 1; $i < 15; $i++) {
            $condition = new Conditions();
            $arrayStatus =
                [
                    "Neuf",
                    "Bon état",
                    "Légèrement usé"
                ];
            $condition
                ->setStatus($faker->randomElement($arrayStatus));
            $manager->persist($condition);
            $this->addReference('condition' . $i, $condition);
        }
        $manager->flush();
    }
}