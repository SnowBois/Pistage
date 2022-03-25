<?php

namespace App\Repository;

use App\Entity\MediaContact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MediaContact|null find($id, $lockMode = null, $lockVersion = null)
 * @method MediaContact|null findOneBy(array $criteria, array $orderBy = null)
 * @method MediaContact[]    findAll()
 * @method MediaContact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediaContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MediaContact::class);
    }

    // /**
    //  * @return MediaContact[] Returns an array of MediaContact objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MediaContact
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
