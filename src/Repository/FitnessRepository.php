<?php

namespace App\Repository;

use App\Entity\Fitness;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Fitness|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fitness|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fitness[]    findAll()
 * @method Fitness[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FitnessRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fitness::class);
    }

    // /**
    //  * @return Fitness[] Returns an array of Fitness objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Fitness
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
