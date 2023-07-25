<?php

namespace App\Repository;

use App\Entity\CampagneDeFinancementParticipatif;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CampagneDeFinancementParticipatif|null find($id, $lockMode = null, $lockVersion = null)
 * @method CampagneDeFinancementParticipatif|null findOneBy(array $criteria, array $orderBy = null)
 * @method CampagneDeFinancementParticipatif[]    findAll()
 * @method CampagneDeFinancementParticipatif[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CampagneDeFinancementParticipatifRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CampagneDeFinancementParticipatif::class);
    }

    // /**
    //  * @return CampagneDeFinancementParticipatif[] Returns an array of CampagneDeFinancementParticipatif objects
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
    public function findOneBySomeField($value): ?CampagneDeFinancementParticipatif
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
