<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

        if(in_array('ROLE_ADMIN', $user->getRoles())){
            $recherches = $repositoryRecherche->findAll();

            return $this->render('pistage/index.html.twig', ['recherches' => $recherches,
                                                             'etudiant']);
        }
        else{
            $etudiant = $user->getEtudiant();

            $recherches = $repositoryRecherche->findRecherchesEtEtatsEtEntreprisesEtAdressesEtEmployesByEtudiant($etudiant);
    
            return $this->render('pistage/index.html.twig', ['recherches' => $recherches,
                                                             'etudiant' => $etudiant]);

        }
    } 
}
