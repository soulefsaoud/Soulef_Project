<?php

namespace App\Repository;

use App\Entity\DailyMenu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DailyMenu|null find($id, $lockMode = null, $lockVersion = null)
 * @method DailyMenu|null findOneBy(array $criteria, array $orderBy = null)
 * @method DailyMenu[]    findAll()
 * @method DailyMenu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DailyMenuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DailyMenu::class);
    }

    // /**
    //  * @return DailyMenu[] Returns an array of DailyMenu objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DailyMenu
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
