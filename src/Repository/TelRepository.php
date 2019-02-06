<?php

namespace App\Repository;

use App\Entity\Tel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Tel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tel[]    findAll()
 * @method Tel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TelRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Tel::class);
    }

    // /**
    //  * @return Tel[] Returns an array of Tel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tel
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findBiggerSizeThan($value){
        //récupération de l'em
        $em = $this->getEntityManager();

        //création de la requête
        $query = $em->createQuery(
            'SELECT t FROM App\Entity\Tel t
            WHERE t.taille >:size'
        )->setParameter('size', $value);

        //exécution et renvoie de la requête sous la forme de tableau d'entités
        return $query->execute();
    }

    public function findTelBy($value){
      //récupération de l'em
      $em = $this->getEntityManager();

      //création de la requête
      $query = $em->createQuery(
          'SELECT t FROM App\Entity\Tel t
          WHERE t.marque = :marque'
      )->setParameter('marque', $value);

      //exécution et renvoie de la requête sous la forme de tableau d'entités
      return $query->execute();
    }

    public function findBiggerSizeThanQb($value){
      // on travaille sur l'entité Telephone (le Repo est associé à l'entité Telephone)
      // 't' est l'alias que nous pouvons utiliser par la suite.
      $qb = $this->createQueryBuilder('t');

      // ajout d'une clause 'Where'
      // FROM et SELECT ne sont pas indispensable vu que le qb a été construit en lien avec l'entité Telephone
      $qb->andWhere('t.taille >= :size')
          ->setParameter('size', $value);

      // récupération de la requête
      $query = $qb->getQuery();

      // exécution et renvoie du résultat
      return $query->execute();
    }

    public function findByUrlQb($marque, $type){
      // on travaille sur l'entité Telephone (le Repo est associé à l'entité Telephone)
      // 't' est l'alias que nous pouvons utiliser par la suite.
      $qb = $this->createQueryBuilder('t');

      if($marque !== "0" && $type !== "0"){
        $qb->where('t.marque LIKE :marque')
            ->andWhere('t.type LIKE :type')
            ->setParameters(array('marque' => '%'.$marque.'%' , 'type' => '%'.$type.'%'));
      }
      elseif($marque !== "0"){
        $qb->andWhere('t.marque LIKE :marque')
            ->setParameter('marque', '%'.$marque.'%');
      }
      elseif($type !== 0){
        $qb->andWhere('t.type LIKE :type')
            ->setParameter('type', '%'.$type.'%');
      }

      // récupération de la requête
      $query = $qb->getQuery();


      // exécution et renvoie du résultat
      return $query->execute();
    }

}
