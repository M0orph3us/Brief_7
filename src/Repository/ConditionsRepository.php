<?php

namespace App\Repository;

use App\Entity\Conditions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Conditions>
 *
 * @method Conditions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conditions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conditions[]    findAll()
 * @method Conditions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConditionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conditions::class);
    }

    //    /**
    //     * @return Conditions[] Returns an array of Conditions objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Conditions
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
