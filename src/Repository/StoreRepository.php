<?php

namespace App\Repository;

use App\Entity\Store;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Store>
 *
 * @method Store|null find($id, $lockMode = null, $lockVersion = null)
 * @method Store|null findOneBy(array $criteria, array $orderBy = null)
 * @method Store[]    findAll()
 * @method Store[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StoreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Store::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Store $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Store $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findOneById($value): ?Store
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
    public function findByTitle($partialTitle)
    {

        $rawQuery = "select str.* 
                     from stock as stck 
                     left join book as bk on bk.id = stck.book_id 
                     left join store as str on str.id = stck.store_id
                     where bk.title LIKE '%".$partialTitle."%' and units>0 
                     group by str.id";

        $preparedQuery = $this->_em->getConnection()->prepare($rawQuery);
        $result = $preparedQuery->executeQuery()->fetchAll(Query::HYDRATE_ARRAY);

        return $result;

    }

    // /**
    //  * @return Store[] Returns an array of Store objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Store
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
