<?php

namespace App\Repository;

use App\Entity\Etudiant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Etudiant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Etudiant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Etudiant[]    findAll()
 * @method Etudiant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtudiantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etudiant::class);
    }

    // /**
    //  * @return Etudiant[] Returns an array of Etudiant objects
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
    public function findOneBySomeField($value): ?Etudiant
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    public function findRecherchesEtMediasContactEtEtatsEtEntreprisesEtAdressesEtEmployesEnAttenteSuperieuresA15JoursByEtudiant($etudiant)
    {
        $dateDeuxSemainesAuparavant = new \DateTime('-14 days');

        return $this->createQueryBuilder('rec')
                    ->select('rec,mec,eta,ent,adr,emp,etu')
                    ->join('rec.mediaContact', 'mec')
                    ->join('rec.dernierEtat', 'der')
                    ->join('rec.etatsRecherche', 'eta')
                    ->join('rec.entreprise', 'ent')
                    ->join('ent.adresse', 'adr')
                    ->leftjoin('rec.employe', 'emp')
                    ->join('rec.etudiant', 'etu')
                    ->andWhere('etu = :etudiant')
                    ->andWhere('der.etat = \'En attente\'')
                    ->andWhere('der.date < :dateDeuxSemainesAuparavant')
                    ->setParameter('dateDeuxSemainesAuparavant', $dateDeuxSemainesAuparavant)
                    ->setParameter('etudiant', $etudiant)
                    ->getQuery()
                    ->getResult()
        ;
    }

    public function findEtudiantAvecRecherchesEnAttenteSuperieuresA15Jours()
    {
        $gestionnaireEntite=$this->getEntityManager();
        
        $dateDeuxSemainesAuparavant = new \DateTime('-14 days');
        $requete=$gestionnaireEntite->createQuery('Select etu,derE.date,derE.etat from App\Entity\Etudiant etu join etu.recherches rec join rec.dernierEtat derE where derE.etat=\'Accepté\' and derE.date<:dateDeuxSemainesAuparavant group By etu,derE.etat having COUNT(rec)>0');
        $requete->setParameter('dateDeuxSemainesAuparavant', $dateDeuxSemainesAuparavant);
        return $requete->execute();



















       /* return $this->createQueryBuilder('etu',)
                    ->select('etu,derE.date')
                    ->join('etu.recherches','rec')
                    ->join('rec.dernierEtat','derE')
                    ->andWhere('derE.etat != \'Accepté\'')
                    ->distinct('etu')
                    ->getQuery()
                    ->getResult()
        ;*/
    }
}
