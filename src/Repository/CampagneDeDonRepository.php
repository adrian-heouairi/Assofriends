<?php

namespace App\Repository;

use App\Entity\CampagneDeDon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CampagneDeDon|null find($id, $lockMode = null, $lockVersion = null)
 * @method CampagneDeDon|null findOneBy(array $criteria, array $orderBy = null)
 * @method CampagneDeDon[]    findAll()
 * @method CampagneDeDon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CampagneDeDonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CampagneDeDon::class);
    }

    // /**
    //  * @return CampagneDeDon[] Returns an array of CampagneDeDon objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CampagneDeDon
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
