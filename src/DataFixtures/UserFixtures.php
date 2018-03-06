<?php

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * UserFixtures constructor.
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setEmail('pierre.jehan@gmail.com');
        $password = $this->encoder->encodePassword($admin, 'admin');
        $admin->setPassword($password);
        $admin->setIsAdmin(true);
        $manager->persist($admin);

        $jdupont = new User();
        $jdupont->setUsername('jdupont');
        $jdupont->setEmail('jdupont@gmail.com');
        $password = $this->encoder->encodePassword($jdupont, 'jdupont');
        $jdupont->setPassword($password);
        $manager->persist($jdupont);

        $manager->flush();

        $this->addReference("user-admin", $admin);
        $this->addReference("user-jdupont", $jdupont);
    }
}









