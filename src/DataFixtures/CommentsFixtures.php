<?php

namespace App\DataFixtures;

use App\Entity\Comments;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CommentsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 1; $i < 15; $i++) {
            $comment = new Comments();
            $comment
                ->setComment($faker->paragraph(2))
                ->setVote($faker->boolean())
                ->setAuthor($this->getReference('user' . $i))
                ->setItem($this->getReference('item' . $i));
            $manager->persist($comment);
            $this->addReference('comment' . $i, $comment);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [UsersFixtures::class, ItemsFixtures::class];
    }
}