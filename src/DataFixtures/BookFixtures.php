<?php

namespace App\DataFixtures;


use App\Entity\Book;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class BookFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $odyssee = new Book();
        $odyssee->setTitle("2001 L'odyssée de l'espace");
        $odyssee->setSlug("2001-odyssee-espace");
        $odyssee->setImage("2001.jpg");
        $odyssee->setAuthor($this->getReference("author-clarke"));
        $odyssee->addCategory($this->getReference("cat-roman"));
        $odyssee->addCategory($this->getReference("cat-sf"));
        $manager->persist($odyssee);

        $germinal = new Book();
        $germinal->setTitle("Germinal");
        $germinal->setSlug("germinal");
        $germinal->setImage("germinal.jpg");
        $germinal->setAuthor($this->getReference("author-zola"));
        $germinal->addCategory($this->getReference("cat-roman"));
        $manager->persist($germinal);

        $assomoire = new Book();
        $assomoire->setTitle("L'assomoire");
        $assomoire->setSlug("assomoire");
        $assomoire->setImage("assomoire.jpg");
        $assomoire->setAuthor($this->getReference("author-zola"));
        $assomoire->addCategory($this->getReference("cat-roman"));
        $manager->persist($assomoire);

        $manager->flush();

        $this->addReference("book-odyssee", $odyssee);
        $this->addReference("book-assomoire", $assomoire);
        $this->addReference("book-germinal", $germinal);
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    function getDependencies()
    {
        return [AuthorFixtures::class, CategoryFixtures::class];
    }
}