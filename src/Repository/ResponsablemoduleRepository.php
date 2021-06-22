<?php

namespace App\Repository;

use App\Entity\Responsablemodule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Responsablemodule|null find($id, $lockMode = null, $lockVersion = null)
 * @method Responsablemodule|null findOneBy(array $criteria, array $orderBy = null)
 * @method Responsablemodule[]    findAll()
 * @method Responsablemodule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResponsablemoduleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Responsablemodule::class);
    }

    // /**
    //  * @return Responsablemodule[] Returns an array of Responsablemodule objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Responsablemodule
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
