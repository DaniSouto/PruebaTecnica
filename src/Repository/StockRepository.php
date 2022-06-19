<?php

namespace App\Repository;

use App\Entity\Stock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Stock>
 *
 * @method Stock|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stock|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stock[]    findAll()
 * @method Stock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stock::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Stock $entity, bool $flush = true): void
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
    public function remove(Stock $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Book[] Returns an array of Book objects
     */
    public function findStockByStoreId($storeId)
    {

        $rawQuery = 'select stck.id,
                            stck.units,
                            bk.title, 
                            (select name from author where id=bk.author_id) as author, 
                            (select name from editorial where id=bk.category_id) as editorial,
                            (select name from category where id=bk.category_id) as category
                    from stock stck left join book bk on bk.id = stck.book_id 
                    where stck.store_id = :storeId';

        $params = array(
            'storeId' => $storeId
        );

        $preparedQuery = $this->_em->getConnection()->prepare($rawQuery);
        $result = $preparedQuery->executeQuery($params)->fetchAll(Query::HYDRATE_ARRAY);

        return $result;

    }


    /**
     * @return Book[] Returns an array of Book objects
     */
    public function findStockByBookIdGroupedByStore($bookId)
    {

        $rawQuery = 'select * 
                     from stock left join store on stock.store_id=store.id 
                     where stock.book_id= :bookId 
                     order by units DESC';

        $params = array(
            'bookId' => $bookId
        );

        $preparedQuery = $this->_em->getConnection()->prepare($rawQuery);
        $result = $preparedQuery->executeQuery($params)->fetchAll(Query::HYDRATE_ARRAY);

        return $result;

    }

    // /**
    //  * @return Stock[] Returns an array of Stock objects
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
    public function findOneBySomeField($value): ?Stock
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
