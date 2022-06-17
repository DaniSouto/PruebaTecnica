<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function findOneById($value): ?Book
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    /**
     * @return Book[] Returns an array of Book objects
     */
    public function findByTitle($title)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.title LIKE :val')
            ->setParameter('val', '%'.$title.'%')
            ->orderBy('b.priority', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function countBooks()
    {
        return $this->createQueryBuilder('b')
            ->select('sum(b.stock)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}