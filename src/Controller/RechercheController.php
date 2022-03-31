<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Recherche;
use App\Form\RechercheType;

use App\Entity\EtatRecherche;

use App\Repository\EntrepriseRepository;
use App\Repository\RechercheRepository;

use Symfony\Component\HttpFoundation\JsonResponse;

date_default_timezone_set('Europe/Paris');

class RechercheController extends AbstractController
{
    /**
     * @Route("/ajoutRecherche", name="recherche_formulaireAjoutRecherche")
     */
    public function ajouterRecherche(Request $requeteHTTP, EntityManagerInterface $manager): Response
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
            $formulaireNouvelleEntreprise = $formulaireRecherche->get('nouvelleEntreprise')->getData();

            if(!empty($formulaireNouvelleEntreprise))
            {
                // Une nouvelle entreprise a été saisie
                $nouvelleEntreprise = $formulaireNouvelleEntreprise[array_key_first($formulaireNouvelleEntreprise)];

                $recherche->setEntreprise($nouvelleEntreprise);
            }
            else
            {
                // Une entreprise a été sélectionnée dans la liste

                // On récupère l'employé saisi pour l'assigner à l'entreprise choisie
                $employe = $recherche->getEmploye();
                $entreprise = $recherche->getEntreprise();

                // On vérifie si l'employé a été saisi
                if($employe != null)
                {
                    // On vérifie si c'était un employé parmi la liste ou un nouvel employé ajouté
                    if($employe->getEntreprise() == null)
                    {
                        // Si c'était un nouvel employé ajouté, on définit son entreprise comme étant celle saisie
                        $employe->setEntreprise($entreprise);
                    }
                }
            }

            $formulaireNouvelEmploye = $formulaireRecherche->get('nouvelEmploye')->getData();

            if(!empty($formulaireNouvelEmploye))
            {
                // Un nouvel employé a été saisi
                $nouvelEmploye = $formulaireNouvelEmploye[array_key_first($formulaireNouvelEmploye)];

                $recherche->setEmploye($nouvelEmploye);
                $recherche->getEntreprise()->addEmploye($nouvelEmploye);
            }

            // On assigne la recherche saisie à l'utilisateur connecté
            $etudiant = $this->getUser()->getEtudiant();
            $recherche->setEtudiant($etudiant);

            // On crée le premier état de la recherche et on l'assigne à la recherche
            $etat = $formulaireRecherche->get('premierEtat')->getData();

            $etatRecherche = new EtatRecherche();
            $etatRecherche->setEtat($etat);
            $etatRecherche->setDate(new \DateTime());

            $recherche->addEtatRecherche($etatRecherche);
            $recherche->setDernierEtat($etatRecherche);

            // Enregistrer la recherche en BD
            $manager->persist($recherche);
            $manager->persist($etatRecherche);
            $manager->flush();

            // Rediriger l'utilisateur vers la page d'accueil affichant la liste des recherches
            return $this->redirectToRoute('pistage_accueil');
        }

        // Récupération de la liste des entreprises disponibles

        return $this->render('recherche/formulaireAjoutModificationRecherche.html.twig', ['vueFormulaireRecherche' => $formulaireRecherche->createView(), 'action' => 'ajouter']);
    }

    /**
     * @Route("/modifierRecherche/{id}", name="recherche_formulaireModificationRecherche")
     */
    public function modifierRecherche(Request $requeteHTTP, EntityManagerInterface $manager, Recherche $recherche): Response
    {	
        // Création d'un objet formulaire pour modifier une recherche
        $formulaireRecherche = $this->createForm(RechercheType::class, $recherche);

        // Récupération des données dans $entreprise si elles ont été soumises
        $formulaireRecherche->handleRequest($requeteHTTP);

        // Traiter les données du formulaire s'il a été soumis et est valide
        if($formulaireRecherche->isSubmitted() && $formulaireRecherche->isValid())
        {
            // On récupère l'employé saisi pour l'assigner à l'entreprise choisie
            $employe = $recherche->getEmploye();
            $entreprise = $recherche->getEntreprise();

            // On vérifie si l'employé a été saisi
            if($employe != null)
            {
                // On vérifie si c'était un employé parmi la liste ou un nouvel employé ajouté
                if($employe->getEntreprise() == null)
                {
                    // Si c'était un nouvel employé ajouté, on définit son entreprise comme étant celle saisie
                    $employe->setEntreprise($entreprise);
                }
            }

            // On assigne la recherche saisie à l'utilisateur connecté
            $etudiant = $this->getUser()->getEtudiant();
            $recherche->setEtudiant($etudiant);

            // On crée le nouvel état de la recherche et on l'assigne à la recherche
            $etat = $formulaireRecherche->get('premierEtat')->getData();

            $etatRecherche = new EtatRecherche();
            $etatRecherche->setEtat($etat);
            $etatRecherche->setDate(new \DateTime());

            $recherche->addEtatRecherche($etatRecherche);
            $recherche->setDernierEtat($etatRecherche);

            // Enregistrer la recherche en BD
            $manager->persist($recherche);
            $manager->persist($etatRecherche);
            $manager->flush();

            // Rediriger l'utilisateur vers la page d'accueil affichant la liste des recherches
            return $this->redirectToRoute('pistage_accueil');
        }

        
        // Récupération de la liste des entreprises disponibles
        return $this->render('recherche/formulaireAjoutModificationRecherche.html.twig', ['vueFormulaireRecherche' => $formulaireRecherche->createView(), 'action' => 'modifier']);
    }

    /**
     * @Route("/alertes", name="recherche_alertes")
     */
    public function recupererAlertes(Request $request, RechercheRepository $repositoryRecherche): JsonResponse
    {
        $etudiant = $this->getUser()->getEtudiant();

        return new JsonResponse($repositoryRecherche->findRecherchesEnAttenteSuperieuresA15JoursByEtudiant($etudiant));
    }

    /**
     * @Route("/relances", name="pistage_relancesTableau")
     */
    public function afficherRelancesDansTableau(RechercheRepository $repositoryRecherche): Response
    {
        $user = $this->getUser();

        $etudiant = $user->getEtudiant();

        $recherchesARelancer = $repositoryRecherche->findRecherchesEtMediasContactEtEtatsEtEntreprisesEtAdressesEtEmployesEnAttenteSuperieuresA15JoursByEtudiant($etudiant);

        return $this->render('recherche/recherchesARelancer.html.twig', ['recherches' => $recherchesARelancer,
                                                         'etudiant' => $etudiant]);
    }
}
