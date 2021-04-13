<?php

namespace App\Repository;

use App\Entity\Objednavka;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Objednavka|null find($id, $lockMode = null, $lockVersion = null)
 * @method Objednavka|null findOneBy(array $criteria, array $orderBy = null)
 * @method Objednavka[]    findAll()
 * @method Objednavka[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObjednavkaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Objednavka::class);
    }

    // /**
    //  * @return Objednavka[] Returns an array of Objednavka objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Objednavka
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
