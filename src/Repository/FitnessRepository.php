<?php

namespace App\Repository;

use App\Entity\Fitness;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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

    public function findAllQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p');
    }

    public function findAllProduitByFilter($search)
    {
        $query = $this->findAllQuery();

        if($search->getFiltrerParNom()){
            $query = $query->andWhere('p.nom = :nom');
            $query->setParameter('nom', $search->getFiltrerParNom());
        }

        if($search->getFiltrerParCategorie()){
            $query = $query->andWhere('p.categorie = :categorie');
            $query->setParameter('categorie', $search->getFiltrerParCategorie());
        }

        return $query->getQuery();
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
