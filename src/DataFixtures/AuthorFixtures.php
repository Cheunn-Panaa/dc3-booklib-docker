<?php

namespace App\DataFixtures;


use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AuthorFixtures extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $clarke = new Author();
        $clarke->setFirstname("Arthur");
        $clarke->setLastname("Clarke");
        $manager->persist($clarke);

        $zola = new Author();
        $zola->setFirstname("Emile");
        $zola->setLastname("Zola");
        $manager->persist($zola);

        $kafka = new Author();
        $kafka->setFirstname("Franz");
        $kafka->setLastname("Kafka");
        $manager->persist($kafka);

        $manager->flush();

        $this->addReference("author-clarke", $clarke);
        $this->addReference("author-zola", $zola);
        $this->addReference("author-kafka", $kafka);
    }
}