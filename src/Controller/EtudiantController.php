<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Etudiant;
use App\Form\EtudiantType;

class EtudiantController extends AbstractController
{
    /**
     * @Route("/ajoutEtudiant", name="etudiant_formulaireAjoutEtudiant")
     */
    public function ajouterEtudiant(Request $requeteHTTP, EntityManagerInterface $manager): Response
    {
        $fichierCSV = $form['fichierCSV']->getData();
            $donneesFichierCSV = fopen($fichierCSV, "r");
            $nbLignes = count(file($fichierCSV));
            $premiereLigne = chop(fgets($donneesFichierCSV));
            if ($premiereLigne === "NOM;PRENOM;MAIL") {
                for ($i = 0; $i <= $nbLignes; $i++) {
                    $ligneActuelle = fgets($donneesFichierCSV);
                    $etudiantActuel = explode(";", $ligneActuelle);
                    $etudiant = new Etudiant();
                    $etudiant->setNom($etudiantActuel[GroupeEtudiantController::COLONNE_NOM]);
                    $etudiant->setPrenom($etudiantActuel[GroupeEtudiantController::COLONNE_PRENOM]);
                    $etudiant->setMail($etudiantActuel[GroupeEtudiantController::COLONNE_MAIL]);
                    $etudiant->setEstDemissionaire(false);
                    $etudiant->addGroupe($groupeEtudiant);
                    $entityManager->persist($etudiant);
                }
            }
    }
}
