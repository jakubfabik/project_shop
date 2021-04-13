<?php

namespace App\Repository;

use App\Entity\Pouzivatel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Pouzivatel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pouzivatel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pouzivatel[]    findAll()
 * @method Pouzivatel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PouzivatelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pouzivatel::class);
    }

    // /**
    //  * @return Pouzivatel[] Returns an array of Pouzivatel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Pouzivatel
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
