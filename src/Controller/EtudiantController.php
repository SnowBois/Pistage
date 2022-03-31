<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Adresse;
use App\Entity\Cursus;
use App\Form\EtudiantType;
use App\Form\FormulaireCSVType;
use App\Repository\CursusRepository;
use App\Repository\AdresseRepository;
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
    const COLONNE_CEDEX = 9;
    const COLONNE_PAYS = 10;
    const COLONNE_CURSUS_NOM_LONG = 11;
    const COLONNE_CURSUS_NOM_COURT = 12;

    /**
     * @Route("/csv", name="etudiant_ajout_par_CSV", methods={"GET", "POST"})
     */
    public function ajoutCSV(Request $request, EntityManagerInterface $manager, 
                            EtudiantRepository $repositoryEtudiant, AdresseRepository $repositoryAdresse,
                            CursusRepository $repositoryCursus):Response
    {
        $form = $this->createForm(FormulaireCSVType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $fichierCSV = $form['fichierCSV']->getData();
            $fichier = fopen($fichierCSV, "r");
            $nbLignes = count(file($fichierCSV));
            $premiereLigne = chop(fgets($fichier));
            if ($premiereLigne === "NOM;PRENOM;NUMERO_ETUDIANT;NUMERO_TELEPHONE;ADRESSE_MAIL;VOIE;BATIMENT_RESIDENCE_ZI;COMMUNE;CODE_POSTAL;CEDEX;PAYS;CURSUS_NOM_LONG;CURSUS_NOM_COURT") {
                for ($i = 0; $i < $nbLignes - 1; ++$i) {
                    $ligneCourante = utf8_encode(fgets($fichier));
                    $etudiantCourant = explode(";", $ligneCourante);

                    $etudiant = new Etudiant();
                    $etudiant->setNom($etudiantCourant[EtudiantController::COLONNE_NOM]);
                    $etudiant->setPrenom($etudiantCourant[EtudiantController::COLONNE_PRENOM]);
                    $etudiant->setNumeroEtudiant($etudiantCourant[EtudiantController::COLONNE_NUMERO_ETUDIANT]);
                    $etudiant->setNumeroTelephone($etudiantCourant[EtudiantController::COLONNE_NUMERO_TELEPHONE]);
                    $etudiant->setAdresseMail($etudiantCourant[EtudiantController::COLONNE_ADRESSE_MAIL]);
                    $etudiant->setPremiereConnexion(true);

                    // On vérifie que l'étudiant spécifié n'existe pas déjà
                    $resultat = $repositoryEtudiant->findOneBy(['numeroEtudiant' => $etudiant->getNumeroEtudiant()]);
                    
                    if($resultat == null)
                    {
                        // L'étudiant n'est pas dans la base de données
                        $adresse = new Adresse();
                        $adresse->setVoie($etudiantCourant[EtudiantController::COLONNE_VOIE]);
                        $adresse->setBatimentResidenceZI($etudiantCourant[EtudiantController::COLONNE_BATIMENT_RESIDENCE_ZI]);
                        $adresse->setCommune($etudiantCourant[EtudiantController::COLONNE_COMMUNE]);
                        $adresse->setCodePostal($etudiantCourant[EtudiantController::COLONNE_CODE_POSTAL]);
                        $adresse->setPays($etudiantCourant[EtudiantController::COLONNE_PAYS]);

                        // On vérifie que l'adresse spécifiée n'existe pas déjà
                        $resultat = $repositoryAdresse->findOneBy(['voie' => $adresse->getVoie(), 
                                                                    'batimentResidenceZI' => $adresse->getBatimentResidenceZI(),
                                                                    'commune' => $adresse->getCommune(),
                                                                    'codePostal' => $adresse->getCodePostal(),
                                                                    'pays' => $adresse->getPays(),
                                                                    'cedex' => $adresse->getCedex()
                                                                    ]);

                        if($resultat == null)
                        {
                            // L'adresse n'est pas dans la base de données
                            $etudiant->setAdresse($adresse);
                            $adresse->addEtudiant($etudiant);
                        }
                        else
                        {
                            // L'adresse existe déjà
                            $etudiant->setAdresse($resultat);
                            $resultat->addEtudiant($etudiant);
                        }

                        $cursus = new Cursus();
                        $cursus->setNomLong($etudiantCourant[EtudiantController::COLONNE_CURSUS_NOM_LONG]);
                        $cursus->setNomCourt($etudiantCourant[EtudiantController::COLONNE_CURSUS_NOM_COURT]);

                        // On vérifie que le cursus spécifié n'existe pas déjà
                        $resultat = $repositoryCursus->findOneBy(['nomLong' => $cursus->getNomLong(), 
                                                                'nomCourt' => $cursus->getNomCourt()
                                                                ]);
                        
                        if($resultat == null)
                        {
                            // Le cursus n'est pas dans la base de données
                            $etudiant->setCursus($cursus);
                            $cursus->addEtudiant($etudiant);
                        }
                        else
                        {
                            // Le cursus existe déjà
                            $etudiant->setCursus($resultat);
                            $resultat->addEtudiant($etudiant);
                        }

                        $manager->persist($etudiant);
                        $manager->flush();  
                        
                        // On flush à chaque itération pour éviter de créer des doublons si des
                        // lignes dans le CSV ont la même adresse ou le même cursus
                    }
                    else
                    {
                        // L'étudiant est déjà en base de données, on ne le persiste pas
                    }
                }
            }

            return $this->redirectToRoute('etudiant_index');
        }

        return $this->render('etudiant/formulaireAjoutEtudiantsCSV.html.twig', [
            'vueFormulaireEtudiant' => $form->createView()
        ]);

        
    }

    /*public function recupererEtudiantSansRechercheRecentes(Request $request, EtudiantRepository $repositoryEtudiant): JsonResponse
    {

        return new JsonResponse($repositoryRecherche->findRecherchesEnAttenteSuperieuresA15JoursByEtudiant($etudiant));
    }*/
}
