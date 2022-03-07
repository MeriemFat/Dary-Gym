<?php

namespace App\Repository;

use App\Entity\Acceuille;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Acceuille|null find($id, $lockMode = null, $lockVersion = null)
 * @method Acceuille|null findOneBy(array $criteria, array $orderBy = null)
 * @method Acceuille[]    findAll()
 * @method Acceuille[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AcceuilleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Acceuille::class);
    }

    // /**
    //  * @return Acceuille[] Returns an array of Acceuille objects
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
    public function findOneBySomeField($value): ?Acceuille
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
