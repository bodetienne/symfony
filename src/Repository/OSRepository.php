<?php

namespace App\Repository;

use App\Entity\OS;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method OS|null find($id, $lockMode = null, $lockVersion = null)
 * @method OS|null findOneBy(array $criteria, array $orderBy = null)
 * @method OS[]    findAll()
 * @method OS[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OSRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OS::class);
    }

    // /**
    //  * @return OS[] Returns an array of OS objects
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
    public function findOneBySomeField($value): ?OS
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
