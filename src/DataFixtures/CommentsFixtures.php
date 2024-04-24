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
                ->setAuthor($this->getReference('user' . $i))
                ->setComment($faker->paragraph(2))
                ->setItem($this->getReference('item' . $i))
                ->setVote($faker->boolean());
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