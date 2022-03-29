<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Etudiant;
use App\Entity\Recherche;
use App\Repository\RechercheRepository;

class PistageController extends AbstractController
{
    /**
     * @Route("/", name="redirect_to_pistage_accueil")
     */

    public function redirectToIndex() : Response
    {
        return $this->redirectToRoute('pistage_accueil');
    }

    /**
     * @Route("/accueil", name="pistage_accueil")
     */
    public function index(RechercheRepository $repositoryRecherche): Response
    {
        $user = $this->getUser();

        if(in_array('ROLE_ADMIN', $user->getRoles()))
        {
            // Redirection vers l'ensemble des journaux pour Admin

            $recherches = $repositoryRecherche->findAllRecherchesEtEtudiantsEtMediasContactEtEtatsEtEntreprisesEtAdressesEtEmployes();

            return $this->render('pistage/index.html.twig', ['recherches' => $recherches]);
        }
        else
        {
            // Redirection vers le journal spécifique de l'étudiant

            $etudiant = $user->getEtudiant();

            $recherches = $repositoryRecherche->findRecherchesEtMediasContactEtEtatsEtEntreprisesEtAdressesEtEmployesByEtudiant($etudiant);
    
            return $this->render('pistage/index.html.twig', ['recherches' => $recherches,
                                                             'etudiant' => $etudiant]);
        }
    } 

   

    /**
     * @Route("/profil", name="pistage_profil")
     */
    public function afficherProfil(): Response
    {
        $user = $this->getUser();

        if(in_array('ROLE_ADMIN', $user->getRoles()))
        {
            // Redirection vers la page de profil Admin

            return $this->render('pistage/index.html.twig', ['recherches' => $recherches]);
        }
        else
        {
            // Redirection vers la page de profil étudiant

            $etudiant = $user->getEtudiant();
    
            return $this->render('etudiant/profil.html.twig', ['etudiant' => $etudiant]);
        }
    }
}
