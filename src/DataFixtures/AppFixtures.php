<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Recherche;
use App\Entity\EtatRecherche;
use App\Entity\Employe;
use App\Entity\Entreprise;
use App\Entity\Utilisateur;
use App\Entity\Etudiant;
use App\Entity\Adresse;
use App\Entity\Cursus;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création d'un générateur de données Faker
		$faker = \Faker\Factory::create('fr_FR');

        $etudiant = new Etudiant();
        $etudiant->setNom("Longy");
        $etudiant->setPrenom("Simon");
        $etudiant->setNumeroEtudiant("573323");
        $etudiant->setAdresseMail("slongy@iutbayonne.univ-pau.fr");
        $etudiant->setNumeroTelephone(str_replace(' ', '', $faker->serviceNumber()));

        $adresse = new Adresse();
        $adresse->setVoie($faker->streetAddress());
        $adresse->setBatimentResidenceZI($faker->secondaryAddress());
        $adresse->setCommune($faker->city());
        $adresse->setCodePostal($faker->randomNumber(5, true));
        $adresse->setPays($faker->country());

        $cursus = new Cursus();
        $cursus->setNomLong("Diplôme Universitaire de Technologie en Informatique");
        $cursus->setNomCourt("DUT Info");

        $utilisateur = new Utilisateur();
        $utilisateur->setUsername("slongy");
        $utilisateur->setPassword('$2y$10$xKguGVF8mtNfaFu3hohum.YFrS/5x0aJ4wd8InSSMJhnKyhXHZbUi');
        $utilisateur->setRoles(["ROLE_USER"]);

        $adresse->addEtudiant($etudiant);

        $cursus->addEtudiant($etudiant);

        $etudiant->setUtilisateur($utilisateur);
        $utilisateur->setEtudiant($etudiant);

        // On persiste l'utilisateur associé à l'étudiant, ainsi que son adresse et son cursus

        $manager->persist($utilisateur);
        $manager->persist($adresse);
        $manager->persist($cursus);

        $tableauMediasContact = array("Mail", "Présentiel", "Téléphone", "Courrier");
        $tableauTypeEtablissements = array("Administration", "Association", "Entreprise privée", "Entreprise publique", "Mutuelle coopérative", "Autre");
        $tableauStatutsJuridiques = array("Micro-entrepreneur", "EI", "EIRL", "EURL", "SA", "SAS", "SARL", "SASU");
        $tableauEtatsRecherche = array("Refusé", "En attente", "Relancé", "Accepté");

        // On génère entre 10 et 20 recherches
		$nombreRecherches = $faker->numberBetween(10,20);

        for ($i = 1 ; $i <= $nombreRecherches ; $i++)
		{
			$recherche = new Recherche();

            $indiceMediaContact = $faker->numberBetween(0,count($tableauMediasContact) - 1);	
			$recherche->setMediaContact($tableauMediasContact[$indiceMediaContact]);

            $recherche->setObservations($faker->realText(255,2));

            // L'état de la recherche

            $etatRecherche = new EtatRecherche();

            $indiceEtatRecherche = $faker->numberBetween(0,count($tableauEtatsRecherche) - 1);	
			$etatRecherche->setEtat($tableauEtatsRecherche[$indiceEtatRecherche]);

            $etatRecherche->setDate($faker->dateTimeBetween($startDate = '-6 months', $endDate = 'now'));

            // L'adresse de l'entreprise associée à la recherche

            $adresse = new Adresse();
            $adresse->setVoie($faker->streetAddress());
            $adresse->setBatimentResidenceZI($faker->buildingNumber());
            $adresse->setCommune($faker->city());
            $adresse->setCodePostal($faker->randomNumber(5, true));
            $adresse->setPays($faker->country());

            // L'entreprise associée à la recherche

            $entreprise = new Entreprise();
            $entreprise->setNom($faker->company());
            $entreprise->setNumeroTelephone(str_replace(' ', '', $faker->serviceNumber()));

            $indiceTypeEtablissement = $faker->numberBetween(0,count($tableauTypeEtablissements) - 1);	
			$entreprise->setTypeEtablissement($tableauTypeEtablissements[$indiceTypeEtablissement]);

            $entreprise->setActivite($faker->realText(50,2));
            $entreprise->setNumeroSIRET(str_replace(' ', '', $faker->siret()));
            $entreprise->setCodeAPEouNAF($faker->randomNumber(4, true) . strtoupper($faker->randomLetter()));

            $indiceStatutJuridique = $faker->numberBetween(0,count($tableauStatutsJuridiques) - 1);	
			$entreprise->setTypeEtablissement($tableauStatutsJuridiques[$indiceStatutJuridique]);

            $entreprise->setEffectif($faker->numberBetween(5, 50));
            $entreprise->setNumeroFax($entreprise->getNumeroTelephone());
            $entreprise->setAdresseMail("contact@" . str_replace(' ', '', strtolower($entreprise->getNom())) . ".com");
            $entreprise->setSiteWeb($faker->domainName());

            // L'employé servant d'interlocuteur à la recherche

            $employe = new Employe();
            $employe->setNom($faker->lastName());
            $employe->setPrenom($faker->firstName());
            $employe->setFonction($faker->jobTitle());
            $employe->setNumeroTelephone(str_replace(' ', '', $faker->serviceNumber()));
            $employe->setAdresseMail($employe->getPrenom() . "." . $employe->getNom() . "@" . str_replace(' ', '', strtolower($entreprise->getNom())) . ".com");

            // Mise en place des relations

            $entreprise->addEmploye($employe);

            $adresse->addEntreprise($entreprise);

            $employe->addRecherche($recherche);

            $entreprise->addRecherche($recherche);

            $etudiant->addRecherche($recherche);

            $recherche->addEtatRecherche($etatRecherche);

            // On persiste toutes les entités générées

            $manager->persist($etatRecherche);
            $manager->persist($recherche);
            $manager->persist($employe);
            $manager->persist($entreprise);
            $manager->persist($adresse);
		}

        // On persiste l'étudiant avec toutes ses recherches

        $manager->persist($etudiant);

        $manager->flush();
    }
}
