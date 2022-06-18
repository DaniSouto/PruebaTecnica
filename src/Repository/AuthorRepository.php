<?php

namespace App\Repository;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    public function findOneById($id): ?Author
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    /**
     * @return Author[] Returns an array of Author objects
     */
    public function findByIdList($authorIdList)
    {

        return $this->createQueryBuilder('a')
            ->andWhere('a.id IN (:authorIdList)')
            ->setParameter('authorIdList', $authorIdList)
            ->getQuery()
            ->getResult()
            ;

    }

    public function createDummyData()
    {

        $em = $this->getEntityManager();

        $author = new Author();
        $author->setName('Patrick Rothfuss');
        $em->persist($author);

        $author = new Author();
        $author->setName('Brandon Sanderson');
        $em->persist($author);

        $author = new Author();
        $author->setName('Isaac Asimov');
        $em->persist($author);

        $em->flush();

    }

}
