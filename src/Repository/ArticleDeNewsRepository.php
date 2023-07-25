<?php

namespace App\Repository;

use App\Entity\ArticleDeNews;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ArticleDeNews|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArticleDeNews|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArticleDeNews[]    findAll()
 * @method ArticleDeNews[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleDeNewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArticleDeNews::class);
    }

    // /**
    //  * @return ArticleDeNews[] Returns an array of ArticleDeNews objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ArticleDeNews
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
