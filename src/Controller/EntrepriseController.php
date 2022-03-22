<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Entity\Adresse;
use App\Form\EntrepriseType;
use App\Form\FormulaireCSVType;
use App\Repository\AdresseRepository;
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

    const COLONNE_CODE_POSTAL = 0;
    const COLONNE_PAYS = 1;
    const COLONNE_STATUT_JURIDIQUE = 2;
    const COLONNE_TYPE_STRUCTURE = 3;
    const COLONNE_EFFECTIF = 4;
    const COLONNE_CODE_NAF = 5;
    const COLONNE_TELEPHONE = 6;
    const COLONNE_FAX = 7;
    const COLONNE_MAIL = 8;
    const COLONNE_SITE_WEB   = 9;
    const COLONNE_SERVICE_ACCUEIL_NOM = 10;
    const COLONNE_SERVICE_ACCUEIL_RESIDENCE = 11;
    const COLONNE_SERVICE_ACCUEIL_CEDEX = 12;
    const COLONNE_SERVICE_ACCUEIL_CODE_POSTAL = 13;
    const COLONNE_SERVICE_ACCUEIL_COMMUNE = 14;
    const COLONNE_SERVICE_ACCUEIL_PAYS= 15;

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
                            CursusRepository $repositoryCursus):Response
    {
        $form = $this->createForm(FormulaireCSVType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $fichierCSV = $form['fichierCSV']->getData();
            $fichier = fopen($fichierCSV, "r");
            $nbLignes = count(file($fichierCSV));
            $premiereLigne = chop(fgets($fichier));
            if ($premiereLigne === "Code Postal;Pays;Statut Juridique;Type de Structure;Effectif;Code NAF;Téléphone;Fax;Mail;SiteWeb;Service d'accueil - Nom;Service d'accueil - Residence;Service d'accueil - Voie, Service d'accueil - Cedex, Service d'accueil - Code postal, Service d'accueil - Commune, Service d'accueil - Pays") {
                for ($i = 0; $i < $nbLignes - 1; ++$i) {
                    $ligneCourante = utf8_encode(fgets($fichier));
                    $entrepriseCourante = explode(";", $ligneCourante);

                    $entreprise = new Entreprise();
                    $entreprise->setNom($entrepriseCourante[EntrepriseController::COLONNE_NOM]);
                    $entreprise->setPrenom($entrepriseCourante[EntrepriseController::COLONNE_PRENOM]);
                    $entreprise->setNumeroentreprise($entrepriseCourante[EntrepriseController::COLONNE_NUMERO_entreprise]);
                    $entreprise->setNumeroTelephone($entrepriseCourante[EntrepriseController::COLONNE_NUMERO_TELEPHONE]);
                    $entreprise->setAdresseMail($entrepriseCourante[EntrepriseController::COLONNE_ADRESSE_MAIL]);

                    // On vérifie que l'étudiant spécifié n'existe pas déjà
                    $resultat = $repositoryEntreprise->findOneBy(['nom' => $entreprise->getNom(), 
                                                                'prenom' => $entreprise->getPrenom(),
                                                                'numeroentreprise' => $entreprise->getNumeroentreprise(),
                                                                'numeroTelephone' => $entreprise->getNumeroTelephone(),
                                                                'adresseMail' => $entreprise->getAdresseMail()
                                                                ]);
                    
                    if($resultat == null)
                    {
                        // L'étudiant n'est pas dans la base de données
                        $adresse = new Adresse();
                        $adresse->setVoie($entrepriseCourante[EntrepriseController::COLONNE_VOIE]);
                        $adresse->setBatimentResidenceZI($entrepriseCourante[EntrepriseController::COLONNE_BATIMENT_RESIDENCE_ZI]);
                        $adresse->setCommune($entrepriseCourante[EntrepriseController::COLONNE_COMMUNE]);
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
                            $adresse->addentreprise($entreprise);
                        }
                        else
                        {
                            // L'adresse existe déjà
                            $entreprise->setAdresse($resultat);
                            $resultat->addentreprise($entreprise);
                        }

                        $cursus = new Cursus();
                        $cursus->setNomLong($entrepriseCourante[EntrepriseController::COLONNE_CURSUS_NOM_LONG]);
                        $cursus->setNomCourt($entrepriseCourante[EntrepriseController::COLONNE_CURSUS_NOM_COURT]);

                        // On vérifie que le cursus spécifié n'existe pas déjà
                        $resultat = $repositoryCursus->findOneBy(['nomLong' => $cursus->getNomLong(), 
                                                                'nomCourt' => $cursus->getNomCourt()
                                                                ]);
                        
                        if($resultat == null)
                        {
                            // Le cursus n'est pas dans la base de données
                            $entreprise->setCursus($cursus);
                            $cursus->addentreprise($entreprise);
                        }
                        else
                        {
                            // Le cursus existe déjà
                            $entreprise->setCursus($resultat);
                            $resultat->addentreprise($entreprise);
                        }

                        $manager->persist($entreprise);
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

            return $this->redirectToRoute('entreprise_index');
        }

        return $this->render('entreprise/formulaireAjoutentreprisesCSV.html.twig', [
            'vueFormulaireentreprise' => $form->createView()
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
