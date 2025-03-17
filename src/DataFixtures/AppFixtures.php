<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\MicroPost;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher
        )
    {}

    public function load(ObjectManager $manager): void
    {
        $user1 = new User();
        $user1->setEmail('admin@admin.com');
        $user1->setPassword($this->userPasswordHasher->hashPassword($user1, 'admin'));
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('john@admin.com');
        $user2->setPassword($this->userPasswordHasher->hashPassword($user2, 'admin'));
        $manager->persist($user2);
        
        $microPost1 = new MicroPost();
        $microPost1->setTitle('Welcome to Poland!');
        $microPost1->setText('Welcome to Poland! This is a great country!');
        $microPost1->setDate(new \DateTime());
        $microPost1->setAuthor($user1);
        $manager->persist($microPost1);

        $microPost2 = new MicroPost();
        $microPost2->setTitle('Welcome to USA!');
        $microPost2->setText('Welcome to USA! This is a great country!');
        $microPost2->setDate(new \DateTime());
        $microPost2->setAuthor($user1);
        $manager->persist($microPost2);

        $microPost3 = new MicroPost();
        $microPost3->setTitle('Welcome to Germany!');
        $microPost3->setText('Welcome to Germany! This is a great country!');
        $microPost3->setDate(new \DateTime());
        $microPost3->setAuthor($user2);
        $manager->persist($microPost3);

        $manager->flush();
    }
}
