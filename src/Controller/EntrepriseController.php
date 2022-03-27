<?php

namespace App\Controller;

use App\Entity\Service;
use App\Entity\Entreprise;
use App\Entity\Adresse;
use App\Form\EntrepriseType;
use App\Form\FormulaireCSVType;
use App\Repository\AdresseRepository;
use App\Repository\ServiceRepository;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/entreprise")
 */
class EntrepriseController extends AbstractController
{
    /**
     * Constantes correspondant aux colonnes du fichier CSV, dans l'ordre de haut en bas
     */

    const COLONNE_NOM_ETABLISSEMENT_ACCUEIL = 0;
    const COLONNE_SIRET = 1;
    const COLONNE_ADRESSE_RESIDENCE = 2;
    const COLONNE_ADRESSE_VOIE = 3;
    const COLONNE_ADRESSE_CEDEX = 4;
    const COLONNE_CODE_POSTAL = 5;
    const COLONNE_COMMUNE = 6;
    const COLONNE_PAYS = 7;
    const COLONNE_STATUT_JURIDIQUE = 8;
    const COLONNE_TYPE_STRUCTURE = 9;
    const COLONNE_EFFECTIF = 10;
    const COLONNE_CODE_NAF = 11;
    const COLONNE_TELEPHONE = 12;
    const COLONNE_FAX = 13;
    const COLONNE_MAIL = 14;
    const COLONNE_SITE_WEB = 15;
    const COLONNE_SERVICE_ACCUEIL_NOM = 16;
    const COLONNE_SERVICE_ACCUEIL_VOIE = 17;
    const COLONNE_SERVICE_ACCUEIL_RESIDENCE = 18;
    const COLONNE_SERVICE_ACCUEIL_CEDEX = 19;
    const COLONNE_SERVICE_ACCUEIL_CODE_POSTAL = 20;
    const COLONNE_SERVICE_ACCUEIL_COMMUNE = 21;
    const COLONNE_SERVICE_ACCUEIL_PAYS = 22;

    /**
     * @Route("/", name="entreprise_index", methods={"GET"})
     */
    public function index(EntrepriseRepository $entrepriseRepository): Response
    {
        return $this->render('entreprise/index.html.twig', [
            'entreprises' => $entrepriseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="entreprise_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $entreprise = new Entreprise();
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($entreprise);
            $entityManager->flush();

            return $this->redirectToRoute('entreprise_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('entreprise/new.html.twig', [
            'entreprise' => $entreprise,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/csv", name="entreprise_ajout_par_CSV", methods={"GET", "POST"})
     */
    public function ajoutCSV(Request $request, EntityManagerInterface $manager, 
                            EntrepriseRepository $repositoryEntreprise, AdresseRepository $repositoryAdresse,
                            ServiceRepository $repositoryService):Response
    {
        $form = $this->createForm(FormulaireCSVType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $fichierCSV = $form['fichierCSV']->getData();
            $fichier = fopen($fichierCSV, "r");
            $nbLignes = count(file($fichierCSV));
            $premiereLigne = utf8_encode(chop(fgets($fichier)));

            if ($premiereLigne === "Nom Etablissement d'accueil;Siret;Adresse Residence;Adresse Voie;Adresse lib cedex;Code Postal;Commune;Pays;Statut Juridique;Type de Structure;Effectif;Code NAF;Téléphone;Fax;Mail;SiteWeb;Service d'accueil - Nom;Service d'accueil - Residence;Service d'accueil - Voie;Service d'accueil - Cedex;Service d'accueil - Code postal;Service d'accueil - Commune;Service d'accueil - Pays")
            {
                for ($i = 0; $i < $nbLignes - 1; ++$i) 
                {
                    $ligneCourante = utf8_encode(fgets($fichier));
                    $entrepriseCourante = explode(";", $ligneCourante);

                    $entreprise = new Entreprise();
                    $entreprise->setNom($entrepriseCourante[EntrepriseController::COLONNE_NOM_ETABLISSEMENT_ACCUEIL]);
                    $entreprise->setNumeroSIRET($entrepriseCourante[EntrepriseController::COLONNE_SIRET]);
                    $entreprise->setStatutJuridique($entrepriseCourante[EntrepriseController::COLONNE_STATUT_JURIDIQUE]);
                    $entreprise->setTypeEtablissement($entrepriseCourante[EntrepriseController::COLONNE_TYPE_STRUCTURE]);
                    $entreprise->setEffectif($entrepriseCourante[EntrepriseController::COLONNE_EFFECTIF]);
                    $entreprise->setCodeAPEouNAF($entrepriseCourante[EntrepriseController::COLONNE_CODE_NAF]);
                    $entreprise->setNumeroTelephone($entrepriseCourante[EntrepriseController::COLONNE_TELEPHONE]);
                    $entreprise->setNumeroFax($entrepriseCourante[EntrepriseController::COLONNE_FAX]);
                    $entreprise->setAdresseMail($entrepriseCourante[EntrepriseController::COLONNE_MAIL]);
                    $entreprise->setSiteWeb($entrepriseCourante[EntrepriseController::COLONNE_SITE_WEB]);
                    $entreprise->setAdresseMail($entrepriseCourante[EntrepriseController::COLONNE_MAIL]);
                    $entreprise->setAdresseMail($entrepriseCourante[EntrepriseController::COLONNE_MAIL]);

                    // On vérifie que l'entreprise spécifiée n'existe pas déjà
                    $resultat = $repositoryEntreprise->findOneBy(['numeroSIRET' => $entreprise->getNumeroSIRET()]);
                    
                    if($resultat == null)
                    {
                        // L'entreprise n'est pas dans la base de données
                        $adresse = new Adresse();
                        $adresse->setVoie($entrepriseCourante[EntrepriseController::COLONNE_ADRESSE_VOIE]);
                        $adresse->setBatimentResidenceZI($entrepriseCourante[EntrepriseController::COLONNE_ADRESSE_RESIDENCE]);
                        $adresse->setCommune($entrepriseCourante[EntrepriseController::COLONNE_COMMUNE]);
                        $adresse->setCEDEX($entrepriseCourante[EntrepriseController::COLONNE_ADRESSE_CEDEX]);
                        $adresse->setCodePostal($entrepriseCourante[EntrepriseController::COLONNE_CODE_POSTAL]);
                        $adresse->setPays($entrepriseCourante[EntrepriseController::COLONNE_PAYS]);

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
                            $entreprise->setAdresse($adresse);
                            $adresse->addEntreprise($entreprise);
                        }
                        else
                        {
                            // L'adresse existe déjà
                            $entreprise->setAdresse($resultat);
                            $resultat->addEntreprise($entreprise);
                        }

                        $service = new Service();
                        $service->setNom($entrepriseCourante[EntrepriseController::COLONNE_SERVICE_ACCUEIL_NOM]);

                        // On vérifie que le service spécifié n'existe pas déjà
                        $resultat = $repositoryService->findOneBy(['entreprise' => $entreprise->getId(), 
                                                                'nom' => $service->getNom()
                                                                ]);

                        if($resultat == null)
                        {
                            // Le service n'est pas dans la base de données
                            $entreprise->addService($service);
                            $service->setEntreprise($entreprise);

                            $adresse = new Adresse();
                            $adresse->setVoie($entrepriseCourante[EntrepriseController::COLONNE_SERVICE_ACCUEIL_VOIE]);
                            $adresse->setBatimentResidenceZI($entrepriseCourante[EntrepriseController::COLONNE_SERVICE_ACCUEIL_RESIDENCE]);
                            $adresse->setCommune($entrepriseCourante[EntrepriseController::COLONNE_SERVICE_ACCUEIL_COMMUNE]);
                            $adresse->setCEDEX($entrepriseCourante[EntrepriseController::COLONNE_SERVICE_ACCUEIL_CEDEX]);
                            $adresse->setCodePostal($entrepriseCourante[EntrepriseController::COLONNE_SERVICE_ACCUEIL_CODE_POSTAL]);
                            $adresse->setPays($entrepriseCourante[EntrepriseController::COLONNE_SERVICE_ACCUEIL_PAYS]);

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
                                $service->setAdresse($adresse);
                                $adresse->addService($service);
                            }
                            else
                            {
                                // L'adresse existe déjà
                                $service->setAdresse($resultat);
                                $resultat->addService($service);
                            }
                        }
                        else
                        {
                            // Le service existe déjà dans l'entreprise
                        }

                        $manager->persist($entreprise);
                        $manager->flush();  
                        
                        // On flush à chaque itération pour éviter de créer des doublons si des
                        // lignes dans le CSV ont la même adresse
                    }
                    else
                    {
                        // L'entreprise est déjà dans la base de données, on ne la persiste pas
                    }
                }
            }

            return $this->redirectToRoute('entreprise_index');
        }

        return $this->render('entreprise/formulaireAjoutEntreprisesCSV.html.twig', [
            'vueFormulaireEntreprise' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="entreprise_show", methods={"GET"})
     */
    public function show(Entreprise $entreprise): Response
    {
        return $this->render('entreprise/show.html.twig', [
            'entreprise' => $entreprise,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="entreprise_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Entreprise $entreprise, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('entreprise_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('entreprise/edit.html.twig', [
            'entreprise' => $entreprise,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="entreprise_delete", methods={"POST"})
     */
    public function delete(Request $request, Entreprise $entreprise, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entreprise->getId(), $request->request->get('_token'))) {
            $entityManager->remove($entreprise);
            $entityManager->flush();
        }

        return $this->redirectToRoute('entreprise_index', [], Response::HTTP_SEE_OTHER);
    }
}
