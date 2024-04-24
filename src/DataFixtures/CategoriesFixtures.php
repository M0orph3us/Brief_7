<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\DataFixtures\SubcategoriesFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class CategoriesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 1; $i < 15; $i++) {
            $category = new Categories();
            $arrayCategories =
                [
                    "Nintendo",
                    "Playstation",
                    "Xbox",
                    "PC",
                    "Sega"
                ];
            $category
                ->setCategory($faker->randomElement($arrayCategories))
                ->addSubcategory($this->getReference('subcategory' . $i));
            $manager->persist($category);
            $this->addReference('category' . $i, $category);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [SubcategoriesFixtures::class];
    }
}
