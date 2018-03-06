<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class BookRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function findLast(int $max) {
        $qb = $this->createQueryBuilder('book')
            ->select('book, author')
            ->join('book.author', 'author')
            ->orderBy('book.createdAt', 'DESC')
            ->setMaxResults($max)
            ->getQuery();

        return $qb->execute();
    }
}