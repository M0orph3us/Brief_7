<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $hasher)
    {
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 1; $i < 15; $i++) {
            $user = new Users();
            $user
                ->setUsername()
                ->setEmail()
                ->setCreatedAt()
                ->setPassword()
                ->setRoles(['ROLE_USER'])
                ->setBirthday();
            $manager->persist($user);
            $this->addReference('user' . $i, $user);
        }


        $manager->flush();
    }
}
