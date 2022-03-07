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
     * @Route("/accueil", name="pistage_accueil")
     */
    public function index(RechercheRepository $repositoryRecherche): Response
    {
        $etudiant = $this->getUser()->getEtudiant();

        $recherches = $repositoryRecherche->findRecherchesEtEtatsEtEntreprisesEtAdressesEtEmployesByEtudiant($etudiant);

        return $this->render('pistage/index.html.twig', ['recherches' => $recherches,
                                                         'etudiant' => $etudiant]);
    }
}
