<?php

namespace App\DataFixtures;

use App\Entity\Items;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ItemsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 1; $i < 15; $i++) {
            $item = new Items();
            $arrayItems =
                [
                    "PS4",
                    "PS5",
                    "XboxOne",
                    "Xbox Serie X",
                    "PSP",
                    "GameBoy",
                    "FF7",
                    "Doom",
                    "Fornite",
                    "Halo",
                    "Duke Nukem",
                    "Manette",
                    "Batterie",
                    "Casque",
                    "Megadrive",
                    "Sonic",
                    "Mario",
                    "Wii u",
                    "Zelda Ocarina Of Time"
                ];
            $item
                ->setName($faker->randomElement($arrayItems))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->DateTime()))
                ->setPrice($faker->randomFloat(2, 10, 200))
                ->setStock($faker->numberBetween(5, 200))
                ->setDescription($faker->paragraph(1))
                ->setCategory($this->getReference('category' . $i))
                ->setSubcategory($this->getReference('subcategory' . $i))
                ->setStatus($this->getReference('condition' . $i))
                ->setSeller($this->getReference('user' . $i))
                ->setImageName($faker->imageUrl());
            $manager->persist($item);
            $this->addReference('item' . $i, $item);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [CategoriesFixtures::class, SubcategoriesFixtures::class, ConditionsFixtures::class, UsersFixtures::class];
    }
}