<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Adresse;
use App\Form\EtudiantType;
use App\Form\EtudiantCSVType;
use App\Repository\EtudiantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/etudiant")
 */
class EtudiantController extends AbstractController
{
    const COLONNE_NOM = 0;
    const COLONNE_PRENOM = 1;
    const COLONNE_NUMERO_ETUDIANT = 2;
    const COLONNE_NUMERO_TELEPHONE = 3;
    const COLONNE_ADRESSE_MAIL = 4;
    const COLONNE_VOIE = 5;
    const COLONNE_BATIMENT_RESIDENCE_ZI = 6;
    const COLONNE_COMMUNE = 7;
    const COLONNE_CODE_POSTAL = 8;
    const COLONNE_PAYS = 9;
    const COLONNE_FORMATION = 10;

    /**
     * @Route("/", name="etudiant_index", methods={"GET"})
     */
    public function index(EtudiantRepository $etudiantRepository): Response
    {
        return $this->render('etudiant/index.html.twig', [
            'etudiants' => $etudiantRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="etudiant_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($etudiant);
            $manager->flush();

            return $this->redirectToRoute('etudiant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('etudiant/new.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/csv", name="etudiant_ajout_par_CSV", methods={"GET", "POST"})
     */
    public function ajoutCSV(Request $request, EntityManagerInterface $manager):Response
    {
        $data = ['message' => 'type your message here'];
        $form = $this->createForm(EtudiantCSVType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $fichierCSV = $form['fichierCSV']->getData();
            $fichier = fopen($fichierCSV, "r");
            $nbLignes = count(file($fichierCSV));
            $premiereLigne = chop(fgets($fichier));
            if ($premiereLigne === "NOM;PRENOM;NUMERO_ETUDIANT;NUMERO_TELEPHONE;ADRESSE_MAIL;VOIE;BATIMENT_RESIDENCE_ZI;COMMUNE;CODE_POSTAL;PAYS") {
                for ($i = 0; $i < $nbLignes - 1; ++$i) {
                    $ligneCourante = fgets($fichier);
                    $etudiantCourant = explode(";", $ligneCourante);
                    $etudiant = new Etudiant();
                    $etudiant->setNom($etudiantCourant[EtudiantController::COLONNE_NOM]);
                    $etudiant->setPrenom($etudiantCourant[EtudiantController::COLONNE_PRENOM]);
                    $etudiant->setNumeroEtudiant($etudiantCourant[EtudiantController::COLONNE_NUMERO_ETUDIANT]);
                    $etudiant->setNumeroTelephone($etudiantCourant[EtudiantController::COLONNE_NUMERO_TELEPHONE]);
                    $etudiant->setAdresseMail($etudiantCourant[EtudiantController::COLONNE_ADRESSE_MAIL]);
                    $adresse = new Adresse();
                    $adresse->setVoie($etudiantCourant[EtudiantController::COLONNE_VOIE]);
                    $adresse->setBatimentResidenceZI($etudiantCourant[EtudiantController::COLONNE_BATIMENT_RESIDENCE_ZI]);
                    $adresse->setCommune($etudiantCourant[EtudiantController::COLONNE_COMMUNE]);
                    $adresse->setCodePostal($etudiantCourant[EtudiantController::COLONNE_CODE_POSTAL]);
                    $adresse->setPays($etudiantCourant[EtudiantController::COLONNE_PAYS]);
                    $etudiant->setAdresse($adresse);                    
                    $manager->persist($etudiant);
                }
            }

            $manager->flush();

            return $this->redirectToRoute('etudiant_index');
        }

        return $this->render('etudiant/formulaireAjoutEtudiantsCSV.html.twig', [
            'vueFormulaireEtudiant' => $form->createView()
        ]);
    }


    /**
     * @Route("/{id}", name="etudiant_show", methods={"GET"})
     */
    public function show(Etudiant $etudiant): Response
    {
        return $this->render('etudiant/show.html.twig', [
            'etudiant' => $etudiant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="etudiant_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Etudiant $etudiant, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            return $this->redirectToRoute('etudiant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('etudiant/edit.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="etudiant_delete", methods={"POST"})
     */
    public function delete(Request $request, Etudiant $etudiant, EntityManagerInterface $manager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etudiant->getId(), $request->request->get('_token'))) {
            $manager->remove($etudiant);
            $manager->flush();
        }

        return $this->redirectToRoute('etudiant_index', [], Response::HTTP_SEE_OTHER);
    }
}
