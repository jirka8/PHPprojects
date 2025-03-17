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

        $user1 = new User();
        $user1->setEmail('john@admin.com');
        $user1->setPassword($this->userPasswordHasher->hashPassword($user1, 'admin'));
        $manager->persist($user1);
        
        $microPost1 = new MicroPost();
        $microPost1->setTitle('Welcome to Poland!');
        $microPost1->setText('Welcome to Poland! This is a great country!');
        $microPost1->setDate(new \DateTime());
        $manager->persist($microPost1);

        $microPost2 = new MicroPost();
        $microPost2->setTitle('Welcome to USA!');
        $microPost2->setText('Welcome to USA! This is a great country!');
        $microPost2->setDate(new \DateTime());
        $manager->persist($microPost2);

        $microPost3 = new MicroPost();
        $microPost3->setTitle('Welcome to Germany!');
        $microPost3->setText('Welcome to Germany! This is a great country!');
        $microPost3->setDate(new \DateTime());
        $manager->persist($microPost3);

        $manager->flush();
    }
}
