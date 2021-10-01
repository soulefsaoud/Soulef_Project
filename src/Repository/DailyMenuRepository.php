<?php

namespace App\Repository;

use App\Entity\DailyMenu;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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

    public function findAllQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p');
    }

    public function findAllProduitByFilter($search)
    {
        $query = $this->findAllQuery();

        if($search->getFiltrerParNom()){
            $query = $query->andWhere('p.name = :name');
            $query->setParameter('name', $search->getFiltrerParNom());
        }

        if($search->getFiltrerParCategorie()){
            $query = $query->andWhere('p.categorie = :categorie');
            $query->setParameter('categorie', $search->getFiltrerParCategorie());
        }

        return $query->getQuery();
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
