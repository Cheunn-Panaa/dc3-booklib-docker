<?php

namespace App\DataFixtures;


use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $roman = new Category();
        $roman->setName("Roman");
        $manager->persist($roman);

        $sf = new Category();
        $sf->setName("Science-Fiction");
        $manager->persist($sf);

        $manager->flush();

        $this->addReference("cat-roman", $roman);
        $this->addReference("cat-sf", $sf);
    }
}