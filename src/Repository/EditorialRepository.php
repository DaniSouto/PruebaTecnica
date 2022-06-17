<?php

namespace App\Repository;

use App\Entity\Editorial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Editorial|null find($id, $lockMode = null, $lockVersion = null)
 * @method Editorial|null findOneBy(array $criteria, array $orderBy = null)
 * @method Editorial[]    findAll()
 * @method Editorial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EditorialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Editorial::class);
    }

    public function findOneById($id): ?Editorial
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function createDummyData()
    {

        $em = $this->getEntityManager();

        $editorial = new Editorial();
        $editorial->setName('Alfaguara');
        $em->persist($editorial);

        $editorial = new Editorial();
        $editorial->setName('Ediciones B');
        $em->persist($editorial);

        $editorial = new Editorial();
        $editorial->setName('Edebe');
        $em->persist($editorial);

        $em->flush();

    }
}
