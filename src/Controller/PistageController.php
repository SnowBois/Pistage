<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PistageController extends AbstractController
{
    /**
     * @Route("/", name="pistage_accueil")
     */
    public function index(): Response
    {
        return $this->render('pistage/index.html.twig', [
            'controller_name' => 'PistageController',
        ]);
    }

    /**
     * @Route("/ajoutRecherche", name="pistage_formulaireAjoutRecherche")
     */
    public function ajouterRecherche(): Response
    {
        return $this->render('pistage/formulaireAjoutRecherche.html.twig');
    }
}
