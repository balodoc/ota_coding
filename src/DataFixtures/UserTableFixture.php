<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserTableFixture extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $moderator = new User();
        $moderator->setEmail('moderator@example.com');
        $moderator->setRoles(['ROLE_MODERATOR']);
        $moderator->setPassword($this->passwordHasher->hashPassword($moderator, 'moderator'));

        $poster = new User();
        $poster->setEmail(':
        ');
        $poster->setRoles(['ROLE_POSTER']);
        $poster->setPassword($this->passwordHasher->hashPassword($poster, 'poster'));

        $seeker = new User();
        $seeker->setEmail('seeker@example.com');
        $seeker->setRoles(['ROLE_SEEKER']);
        $seeker->setPassword($this->passwordHasher->hashPassword($seeker, 'seeker'));

        $manager->persist($moderator);
        $manager->persist($poster);
        $manager->persist($seeker);
        $manager->flush();
    }
}
