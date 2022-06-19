<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
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

    /**
     * @return Book[] Returns an array of Book objects
     */
    public function findByAuthor($authorId)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.author = :val')
            ->setParameter('val', ''.$authorId.'')
            ->orderBy('b.priority', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return Book[] Returns an array of Book objects
     */
    public function findByEditorial($editorialId)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.editorial = :val')
            ->setParameter('val', ''.$editorialId.'')
            ->orderBy('b.priority', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return Book[] Returns an array of Book objects
     */
    public function findByCategory($categorylId)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.category = :val')
            ->setParameter('val', ''.$categorylId.'')
            ->orderBy('b.priority', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return Book[] Returns an array of Book objects
     */
    public function findAuthorsIdByCategoryId($categoryId)
    {

        $rawQuery = 'select bk.author_id from book bk where bk.category_id = :catId';

        $params = array(
            'catId' => $categoryId
        );

        $preparedQuery = $this->_em->getConnection()->prepare($rawQuery);
        $result = $preparedQuery->executeQuery($params)->fetchAll(Query::HYDRATE_ARRAY);

        $authorIdsInCategory = array_column($result, "author_id");

        return $authorIdsInCategory;

    }

    /**
     * @return Book[] Returns an array of Book objects
     */
    public function findSuggestionsByBookOrderedByPriority(Book $book)
    {

        $rawQuery = "select title as name, priority from book bk where bk.category_id=:catId union
                     select name, priority from category
                     union
                     select name, priority from editorial where id in (select category_id from book where category_id=:catId)
                     order by priority ASC
                     limit 8";

        $params = array(
            'catId' => $book->getCategoryId()
        );

        $preparedQuery = $this->_em->getConnection()->prepare($rawQuery);
        $result = $preparedQuery->executeQuery($params)->fetchAll(Query::HYDRATE_ARRAY);

        return $result;

    }


    public function countBooks()
    {
        return $this->createQueryBuilder('b')
            ->select('sum(b.stock)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
