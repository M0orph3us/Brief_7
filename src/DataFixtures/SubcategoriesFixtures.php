<?php

namespace App\DataFixtures;

use App\Entity\Subcategories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Faker\Factory;

class SubcategoriesFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 1; $i < 15; $i++) {
            $subcategory = new Subcategories();
            $arraySubcategories =
                [
                    "Accessoires",
                    "Jeux",
                    "Consoles"
                ];
            $subcategory
                ->setSubcategory($faker->randomElement($arraySubcategories));
            $manager->persist($subcategory);
            $this->addReference('subcategory' . $i, $subcategory);
        }


        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['subcategory'];
    }
}