<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @codeCoverageIgnore
 */
class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $user = new user();
            $user->setUsername($faker->username);
            $user->setEmail($faker->Email);
            $user->setPassword($this->passwordEncoder->encodePassword($user, 'ToDo'));
            $this->addReference('user' . $i, $user);

            $manager->persist($user);
        }

        for ($i = 0; $i < 3; $i++) {
            $user = new user();
            $user->setUsername($faker->username);
            $user->setEmail($faker->Email);
            $user->setRoles(['ROLE_ADMIN']);
            $user->setPassword($this->passwordEncoder->encodePassword($user, 'Admin'));

            $manager->persist($user);
        }

        $manager->flush();
    }
}
