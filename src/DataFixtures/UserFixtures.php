<?php

namespace App\DataFixtures;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class UserFixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder=$passwordEncoder;
    }
    public function load(ObjectManager $manager): void
    {
        $user=new User();
        $user->setUsername('admin');
        $user->setName('Sylwek');
        $user->setSurname('Cebula');

        $user->setEmail('qwerty@gmail.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordEncoder->hashPassword($user,'123'));
        $manager->persist($user);
        $manager->flush();
    }
}
