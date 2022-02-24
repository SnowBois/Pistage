<?php

namespace App\Entity;

use App\Repository\StageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StageRepository::class)
 */
class Stage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $affiliationSecuriteSociale;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $caisseAssuranceMaladie;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombrePersonnesAidant;

    /**
     * @ORM\Column(type="text")
     */
    private $moyensOutilsDisponibles;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $autreMateriel;

    /**
     * @ORM\Column(type="text")
     */
    private $typeTaches;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $autresTaches;

    /**
     * @ORM\Column(type="text")
     */
    private $competences;

    /**
     * @ORM\Column(type="boolean")
     */
    private $confidentiel;

    /**
     * @ORM\Column(type="text")
     */
    private $sujet;

    /**
     * @ORM\Column(type="boolean")
     */
    private $interrompu;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date")
     */
    private $dateFin;

    /**
     * @ORM\Column(type="integer")
     */
    private $dureeEnHeures;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombreJoursTravailHebdomadaires;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombreJoursConges;

    /**
     * @ORM\Column(type="boolean")
     */
    private $gratifie;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $tauxHoraireNetParHeure;

    /**
     * @ORM\Column(type="integer")
     */
    private $montantGratification;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $deviseLocale;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $modalitesVersement;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $modaliteSuiviStagiaire;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $listeAvantagesEnNature;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $natureTravailFourniSuiteAuStage;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $presencesExceptionnelles;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $typeStage;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $thematiqueStage;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $informationsComplementaires;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $modaliteValidationStage;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombreHeuresEnseignement;

    /**
     * @ORM\OneToOne(targetEntity=Recherche::class, mappedBy="stage", cascade={"persist", "remove"})
     */
    private $recherche;

    /**
     * @ORM\ManyToOne(targetEntity=EtablissementEnseignement::class, inversedBy="stages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $etablissementEnseignement;

    /**
     * @ORM\ManyToOne(targetEntity=EnseignantReferent::class, inversedBy="stages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $enseignantReferent;

    /**
     * @ORM\ManyToOne(targetEntity=Adresse::class, inversedBy="stages")
     */
    private $adresse;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAffiliationSecuriteSociale(): ?string
    {
        return $this->affiliationSecuriteSociale;
    }

    public function setAffiliationSecuriteSociale(string $affiliationSecuriteSociale): self
    {
        $this->affiliationSecuriteSociale = $affiliationSecuriteSociale;

        return $this;
    }

    public function getCaisseAssuranceMaladie(): ?string
    {
        return $this->caisseAssuranceMaladie;
    }

    public function setCaisseAssuranceMaladie(string $caisseAssuranceMaladie): self
    {
        $this->caisseAssuranceMaladie = $caisseAssuranceMaladie;

        return $this;
    }

    public function getNombrePersonnesAidant(): ?int
    {
        return $this->nombrePersonnesAidant;
    }

    public function setNombrePersonnesAidant(int $nombrePersonnesAidant): self
    {
        $this->nombrePersonnesAidant = $nombrePersonnesAidant;

        return $this;
    }

    public function getMoyensOutilsDisponibles(): ?string
    {
        return $this->moyensOutilsDisponibles;
    }

    public function setMoyensOutilsDisponibles(string $moyensOutilsDisponibles): self
    {
        $this->moyensOutilsDisponibles = $moyensOutilsDisponibles;

        return $this;
    }

    public function getAutreMateriel(): ?string
    {
        return $this->autreMateriel;
    }

    public function setAutreMateriel(?string $autreMateriel): self
    {
        $this->autreMateriel = $autreMateriel;

        return $this;
    }

    public function getTypeTaches(): ?string
    {
        return $this->typeTaches;
    }

    public function setTypeTaches(string $typeTaches): self
    {
        $this->typeTaches = $typeTaches;

        return $this;
    }

    public function getAutresTaches(): ?string
    {
        return $this->autresTaches;
    }

    public function setAutresTaches(?string $autresTaches): self
    {
        $this->autresTaches = $autresTaches;

        return $this;
    }

    public function getCompetences(): ?string
    {
        return $this->competences;
    }

    public function setCompetences(string $competences): self
    {
        $this->competences = $competences;

        return $this;
    }

    public function getConfidentiel(): ?bool
    {
        return $this->confidentiel;
    }

    public function setConfidentiel(bool $confidentiel): self
    {
        $this->confidentiel = $confidentiel;

        return $this;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getInterrompu(): ?bool
    {
        return $this->interrompu;
    }

    public function setInterrompu(bool $interrompu): self
    {
        $this->interrompu = $interrompu;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getDureeEnHeures(): ?int
    {
        return $this->dureeEnHeures;
    }

    public function setDureeEnHeures(int $dureeEnHeures): self
    {
        $this->dureeEnHeures = $dureeEnHeures;

        return $this;
    }

    public function getNombreJoursTravailHebdomadaires(): ?int
    {
        return $this->nombreJoursTravailHebdomadaires;
    }

    public function setNombreJoursTravailHebdomadaires(int $nombreJoursTravailHebdomadaires): self
    {
        $this->nombreJoursTravailHebdomadaires = $nombreJoursTravailHebdomadaires;

        return $this;
    }

    public function getNombreJoursConges(): ?int
    {
        return $this->nombreJoursConges;
    }

    public function setNombreJoursConges(int $nombreJoursConges): self
    {
        $this->nombreJoursConges = $nombreJoursConges;

        return $this;
    }

    public function getGratifie(): ?bool
    {
        return $this->gratifie;
    }

    public function setGratifie(bool $gratifie): self
    {
        $this->gratifie = $gratifie;

        return $this;
    }

    public function getTauxHoraireNetParHeure(): ?float
    {
        return $this->tauxHoraireNetParHeure;
    }

    public function setTauxHoraireNetParHeure(?float $tauxHoraireNetParHeure): self
    {
        $this->tauxHoraireNetParHeure = $tauxHoraireNetParHeure;

        return $this;
    }

    public function getMontantGratification(): ?int
    {
        return $this->montantGratification;
    }

    public function setMontantGratification(int $montantGratification): self
    {
        $this->montantGratification = $montantGratification;

        return $this;
    }

    public function getDeviseLocale(): ?string
    {
        return $this->deviseLocale;
    }

    public function setDeviseLocale(string $deviseLocale): self
    {
        $this->deviseLocale = $deviseLocale;

        return $this;
    }

    public function getModalitesVersement(): ?string
    {
        return $this->modalitesVersement;
    }

    public function setModalitesVersement(string $modalitesVersement): self
    {
        $this->modalitesVersement = $modalitesVersement;

        return $this;
    }

    public function getModaliteSuiviStagiaire(): ?string
    {
        return $this->modaliteSuiviStagiaire;
    }

    public function setModaliteSuiviStagiaire(string $modaliteSuiviStagiaire): self
    {
        $this->modaliteSuiviStagiaire = $modaliteSuiviStagiaire;

        return $this;
    }

    public function getListeAvantagesEnNature(): ?string
    {
        return $this->listeAvantagesEnNature;
    }

    public function setListeAvantagesEnNature(?string $listeAvantagesEnNature): self
    {
        $this->listeAvantagesEnNature = $listeAvantagesEnNature;

        return $this;
    }

    public function getNatureTravailFourniSuiteAuStage(): ?string
    {
        return $this->natureTravailFourniSuiteAuStage;
    }

    public function setNatureTravailFourniSuiteAuStage(string $natureTravailFourniSuiteAuStage): self
    {
        $this->natureTravailFourniSuiteAuStage = $natureTravailFourniSuiteAuStage;

        return $this;
    }

    public function getPresencesExceptionnelles(): ?string
    {
        return $this->presencesExceptionnelles;
    }

    public function setPresencesExceptionnelles(?string $presencesExceptionnelles): self
    {
        $this->presencesExceptionnelles = $presencesExceptionnelles;

        return $this;
    }

    public function getTypeStage(): ?string
    {
        return $this->typeStage;
    }

    public function setTypeStage(string $typeStage): self
    {
        $this->typeStage = $typeStage;

        return $this;
    }

    public function getThematiqueStage(): ?string
    {
        return $this->thematiqueStage;
    }

    public function setThematiqueStage(string $thematiqueStage): self
    {
        $this->thematiqueStage = $thematiqueStage;

        return $this;
    }

    public function getInformationsComplementaires(): ?string
    {
        return $this->informationsComplementaires;
    }

    public function setInformationsComplementaires(?string $informationsComplementaires): self
    {
        $this->informationsComplementaires = $informationsComplementaires;

        return $this;
    }

    public function getModaliteValidationStage(): ?string
    {
        return $this->modaliteValidationStage;
    }

    public function setModaliteValidationStage(string $modaliteValidationStage): self
    {
        $this->modaliteValidationStage = $modaliteValidationStage;

        return $this;
    }

    public function getNombreHeuresEnseignement(): ?int
    {
        return $this->nombreHeuresEnseignement;
    }

    public function setNombreHeuresEnseignement(int $nombreHeuresEnseignement): self
    {
        $this->nombreHeuresEnseignement = $nombreHeuresEnseignement;

        return $this;
    }

    public function getRecherche(): ?Recherche
    {
        return $this->recherche;
    }

    public function setRecherche(?Recherche $recherche): self
    {
        // unset the owning side of the relation if necessary
        if ($recherche === null && $this->recherche !== null) {
            $this->recherche->setStage(null);
        }

        // set the owning side of the relation if necessary
        if ($recherche !== null && $recherche->getStage() !== $this) {
            $recherche->setStage($this);
        }

        $this->recherche = $recherche;

        return $this;
    }

    public function getEtablissementEnseignement(): ?EtablissementEnseignement
    {
        return $this->etablissementEnseignement;
    }

    public function setEtablissementEnseignement(?EtablissementEnseignement $etablissementEnseignement): self
    {
        $this->etablissementEnseignement = $etablissementEnseignement;

        return $this;
    }

    public function getEnseignantReferent(): ?EnseignantReferent
    {
        return $this->enseignantReferent;
    }

    public function setEnseignantReferent(?EnseignantReferent $enseignantReferent): self
    {
        $this->enseignantReferent = $enseignantReferent;

        return $this;
    }

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }
}
