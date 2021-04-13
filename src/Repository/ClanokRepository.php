<?php

namespace App\Repository;

use App\Entity\Clanok;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Clanok|null find($id, $lockMode = null, $lockVersion = null)
 * @method Clanok|null findOneBy(array $criteria, array $orderBy = null)
 * @method Clanok[]    findAll()
 * @method Clanok[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClanokRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Clanok::class);
    }

    // /**
    //  * @return Clanok[] Returns an array of Clanok objects
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
    public function findOneBySomeField($value): ?Clanok
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
