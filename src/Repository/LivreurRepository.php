<?php

namespace App\Repository;

use App\Entity\Livraison;
use App\Entity\Livreur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Livreur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livreur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livreur[]    findAll()
 * @method Livreur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livreur::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Livreur $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Livreur $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    // public function nextAvailableLivreur(LivraisonRepository $livraison): void
    // {
    //     $livraisonNull = $livraison->getDateLivraison();

    //     return $this->createQueryBuilder('livreur')
    //         ->andWhere('livreur.livraisons')


    // }

    public function findNextAvailableLivreur()
   {
     // select un livreur parmi les livreurs dont le nombre de livraisons "à faire"(date_livraison = null) est inférieur à 7
    return $this->createQueryBuilder('livreur')
        ->leftJoin(Livraison::class,'livraison')
        ->andWhere('livraison.date_livraison = :val')
        ->setParameter('val', NULL)
        ->getQuery()
        ->getResult()
        ;
   }

    // /**
    //  * @return Livreur[] Returns an array of Livreur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Livreur
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
