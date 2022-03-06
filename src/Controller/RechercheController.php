<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Recherche;
use App\Form\RechercheType;

use App\Repository\EntrepriseRepository;

class RechercheController extends AbstractController
{
    /**
     * @Route("/ajoutRecherche", name="recherche_formulaireAjoutRecherche")
     */
    public function ajouterRecherche(Request $requeteHTTP, EntityManagerInterface $manager, EntrepriseRepository $entrepriseRepository): Response
    {	
        // Création d'une recherche initialement vierge
        $recherche = new Recherche();

        // Création d'un objet formulaire pour ajouter une recherche
        $formulaireRecherche = $this->createForm(RechercheType::class, $recherche);

        // Récupération des données dans $recherche si elles ont été soumises
        $formulaireRecherche->handleRequest($requeteHTTP);

        // Traiter les données du formulaire s'il a été soumis et est valide
        if($formulaireRecherche->isSubmitted() && $formulaireRecherche->isValid())
        {
            // Enregistrer la recherche en BD
            $manager->persist($recherche);
            $manager->flush();

            // Rediriger l'utilisateur vers la page d'accueil affichant la liste des recherches
            return $this->redirectToRoute('pistage_accueil');
        }

        // Récupération de la liste des entreprises disponibles

        return $this->render('recherche/formulaireAjoutRecherche.html.twig', ['vueFormulaireRecherche' => $formulaireRecherche->createView ()]);
    }
}
