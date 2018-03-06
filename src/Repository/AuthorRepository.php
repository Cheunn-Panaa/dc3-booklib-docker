<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Author::class);
    }

    public function searchLike(string $search)
    {
        $search = $search . "%";
        $qb = $this->createQueryBuilder('a');

        $qb->select('a')
            ->where($qb->expr()->like('a.firstname', ':search'))
            ->setParameter(':search', $search);

        return $qb->getQuery()->getResult();
    }
}