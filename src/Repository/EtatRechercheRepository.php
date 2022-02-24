<?php

namespace App\Repository;

use App\Entity\EtatRecherche;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EtatRecherche|null find($id, $lockMode = null, $lockVersion = null)
 * @method EtatRecherche|null findOneBy(array $criteria, array $orderBy = null)
 * @method EtatRecherche[]    findAll()
 * @method EtatRecherche[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtatRechercheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EtatRecherche::class);
    }

    // /**
    //  * @return EtatRecherche[] Returns an array of EtatRecherche objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EtatRecherche
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
