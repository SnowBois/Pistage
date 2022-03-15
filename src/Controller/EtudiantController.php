<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Etudiant;
use App\Form\EtudiantType;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Form\FormError;

class EtudiantController extends AbstractController
{
    /**
     * @Route("/ajoutEtudiant", name="etudiant_formulaireAjoutEtudiant")
     */
    public function ajouterEtudiant(Request $requeteHTTP, EntityManagerInterface $manager): Response
    {
        // Création d'un objet formulaire pour ajouter des étudiants
        $formulaireEtudiant = $this->createForm(EtudiantType::class);

        // Récupération des données dans la variable si elles ont été soumises
        $formulaireEtudiant->handleRequest($requeteHTTP);

        // Traiter les données du formulaire s'il a été soumis et est valide
        if($formulaireEtudiant->isSubmitted() && $formulaireEtudiant->isValid())
        {

            $fichierCSV = $formulaireEtudiant->get('fichierCSV')->getData();

            $donneesFichierCSV = fopen($fichierCSV, "r");
            $nombreLignes = count(file($fichierCSV));

            $premiereLigne = chop(fgets($donneesFichierCSV));

            // On vérifie si le format CSV attendu est respecté
            if ($premiereLigne === "NOM;PRENOM;MAIL") 
            {
                for ($i = 0; $i < $nombreLignes; $i++) 
                {
                    $ligneActuelle = fgets($donneesFichierCSV);
                    $etudiantActuel = explode(";", $ligneActuelle);

                    $etudiant = new Etudiant();
                    $etudiant->setNom($etudiantActuel[GroupeEtudiantController::COLONNE_NOM]);
                    $etudiant->setPrenom($etudiantActuel[GroupeEtudiantController::COLONNE_PRENOM]);
                    $etudiant->setMail($etudiantActuel[GroupeEtudiantController::COLONNE_MAIL]);
                    $etudiant->setEstDemissionaire(false);
                    $etudiant->addGroupe($groupeEtudiant);

                    $manager->persist($etudiant);
                }
            }
            else
            {
                // Dans le cas contraire, on affiche une erreur à l'utilisateur

                fclose($donneesFichierCSV);

                $formulaireEtudiant->get('fichierCSV')->addError(new FormError('Les colonnes du fichier CSV importé sont incorrectes.'));
                
                return $this->render('etudiant/formulaireAjoutEtudiant.html.twig', ['vueFormulaireEtudiant' => $formulaireEtudiant->createView()]);
            }

            fclose($donneesFichierCSV);

            $manager->flush();

            // Rediriger l'utilisateur vers la page d'accueil affichant la liste des recherches
            return $this->redirectToRoute('pistage_accueil');
        }

        return $this->render('etudiant/formulaireAjoutEtudiant.html.twig', ['vueFormulaireEtudiant' => $formulaireEtudiant->createView()]);
    }
}
