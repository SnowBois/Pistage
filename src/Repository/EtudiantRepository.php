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

    public function findEtudiantByEmail($email)
    {
        return $this    ->createQueryBuilder('etu')
                        ->select('etu')                    
                        ->andWhere('etu.adresseMail = :email')
                        ->setParameter('email', $email)
                        ->getQuery()
                        ->getOneOrNullResult()
        ;       
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
    
    /* Abandon de la requête permettant de récupérer les étudiants n'ayant pas assez cherché */

    public function findEtudiantSansRechercheValide()
    {
        $dateDeuxSemainesAuparavant = new \DateTime('-14 days');
        /* $requete=$gestionnaireEntite->createQuery('Select etu,derE.date,derE.etat from App\Entity\Etudiant etu join etu.recherches rec join rec.dernierEtat derE where derE.etat=\'Accepté\' and derE.date<:dateDeuxSemainesAuparavant group By etu,derE.etat,derE. having COUNT(rec)>0');
        $requete->setParameter('dateDeuxSemainesAuparavant', $dateDeuxSemainesAuparavant);
        return $requete->execute();*/

        /*

        $q1 = $this->createQueryBuilder('et')
                ->select('DISTINCT et.id')
                ->join('et.recherches', 're')
                ->join('re.dernierEtat', 'de')
                ->andWhere('de.etat = \'Accepté\'');

        $q2 = $this->createQueryBuilder('etud')
                ->select('DISTINCT etud.id')
                ->join('etud.recherches', 'rech')
                ->join('rech.dernierEtat', 'der')
                ->andWhere('der.date > :dateDeuxSemainesAuparavant');

        $q2->where($q2->expr()->notIn('etud.id', $q1->getDQL()));
                

        $query = $this->createQueryBuilder('etu')
                    ->select('DISTINCT etu')
                    ->join('etu.recherches', 'rec');

        $query->where($query->expr()->notIn('etud.id', $q2->getDQL()))
            ->setParameter('dateDeuxSemainesAuparavant', $dateDeuxSemainesAuparavant);

        return $query->getQuery()->getArrayResult();

        */
            
        /*
        $expr = $this->getEntityManager()->getExpressionBuilder();
        return $this->createQueryBuilder('etu')
                ->select('etu.nom')
                ->where(
                    $expr->notIn(
                        'rec.id',
                        
                            ->getDQL()
                    )
                )
                ->getQuery()
                ->getResult()
        ;
        */
        
        /*

        SELECT etu FROM etudiant 
        join rec...
        join etat_rec...
        where etu not in (
        Select etu where
            SELECT disticnt(etu) from etudiant
            WHERE etat_rec.dernier = 'accepté'
            and etu not in (
                SELECT etu From etudiant
                where dernier_etat.date > dateYa2semaine
                GroupBy etu
            Having count(rec) > 0
        )*/

        /*

        // Récupération du gestionnaire d'entité
        $gestionnaireEntite = $this->getEntityManager();
        
        $qb = $gestionnaireEntite->createQuery(
            "SELECT etud.id
            FROM App\Entity\Etudiant etud
            JOIN etud.recherches rech
            JOIN rech.dernierEtat eta
            WHERE eta.etat != 'Accepté'
            AND eta.date < :dateDeuxSemainesAuparavant"
        )
        ->setMaxResults(1);
        
        // Construction de la requête
        $requete = $gestionnaireEntite->createQuery(
                "SELECT etu.nom
                FROM App\Entity\Etudiant etu
                JOIN etu.recherches rec
                WHERE etu.id IN (
                    SELECT etud.id
                    FROM App\Entity\Etudiant etud
                    JOIN etud.recherches rech
                    JOIN rech.dernierEtat eta
                    WHERE eta.etat != 'Accepté'
                    AND eta.date < :dateDeuxSemainesAuparavant
                )"  
            );
        
        $requete->setParameter('dateDeuxSemainesAuparavant', $dateDeuxSemainesAuparavant);

        // Exécution de la requête et retour des résultats
        return $requete->execute();
            
        */ 
        
    }
}
