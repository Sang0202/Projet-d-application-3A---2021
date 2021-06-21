<?php

namespace App\Repository;

use App\Entity\ResponsableAnne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ResponsableAnne|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResponsableAnne|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResponsableAnne[]    findAll()
 * @method ResponsableAnne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResponsableAnneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResponsableAnne::class);
    }

    // /**
    //  * @return ResponsableAnne[] Returns an array of ResponsableAnne objects
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
    public function findOneBySomeField($value): ?ResponsableAnne
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
