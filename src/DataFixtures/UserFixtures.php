<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    const USERS = [
        [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'johndoe@gmail.com',
            //'password' => '$2y$13$QVXV3WraPNtdiMo7LHnbEeFiYeHCMFHBkgSjAcxUAjGqZKmcDGLzO'
        ],
        [
            'firstName' => 'Wim',
            'lastName' => 'Hoff',
            'email' => 'iceman@gmail.com',
            //'password' => '$2y$13$5NzVik5uqG9aDrANnbfQxuz03XQeoIU7QF35ZRXVj2HtH1orZCrjy'
        ],
        [
            'firstName' => 'Eva',
            'lastName' => 'Thunberg',
            'email' => 'smoothie_ice@gmail.com',
            //'password' => '$2y$13$gT4bHf6aW9P4dayq2r5pg.Y5lMVBIUNMPw9UxQiauvZ2Nylm3SDWm'
        ],
        [
            'firstName' => 'Marion',
            'lastName' => 'McAllister',
            'email' => 'mcallister76@gmail.com',
            //'password' => '$2y$13$n/EgqVDOGI0hlGxkJR8NPubAItY/.KOd7fBI4OXIgnoOGIZvCHxvy'
        ],
        [
            'firstName' => 'Thona',
            'lastName' => 'Scott',
            'email' => 'travis1996@gmail.com',
            //'password' => '$2y$13$ALjZE0JyqmoHTMFmEvqs1ucr2fj5nExese831f/rtx4qJLa67Pwya'
        ],
    ];
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        foreach (self::USERS as $key => $USER) {
            $user = new User();
            $user->setFirstName($USER['firstName']);
            $user->setLastName($USER['lastName']);
            $user->setEmail($USER['email']);
            $user->setProfilePicture(($key+1).'.jpg');
            $password = $this->hasher->hashPassword($user, 'secret');
            $user->setPassword($password);
            $user->setIsVerified(true);
            $user->setCreateDate($faker->dateTimeThisDecade());
            $manager->persist($user);
            $this->addReference('user_'.$key, $user);
        }
        $manager->flush();
    }
}

