<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdresseRepository::class)
 */
class Adresse
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
    private $voie;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $batimentResidenceZI;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $commune;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $pays;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $cedex;

    /**
     * @ORM\OneToMany(targetEntity=Etudiant::class, mappedBy="adresse")
     */
    private $etudiants;

    /**
     * @ORM\OneToMany(targetEntity=Stage::class, mappedBy="adresse")
     */
    private $stages;

    /**
     * @ORM\OneToMany(targetEntity=EtablissementEnseignement::class, mappedBy="adresse")
     */
    private $etablissementsEnseignement;

    /**
     * @ORM\OneToMany(targetEntity=Service::class, mappedBy="adresse")
     */
    private $services;

    /**
     * @ORM\OneToMany(targetEntity=Entreprise::class, mappedBy="adresse")
     */
    private $entreprises;

    public function __construct()
    {
        $this->etudiants = new ArrayCollection();
        $this->stages = new ArrayCollection();
        $this->etablissementsEnseignement = new ArrayCollection();
        $this->services = new ArrayCollection();
        $this->entreprises = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVoie(): ?string
    {
        return $this->voie;
    }

    public function setVoie(string $voie): self
    {
        $this->voie = $voie;

        return $this;
    }

    public function getBatimentResidenceZI(): ?string
    {
        return $this->batimentResidenceZI;
    }

    public function setBatimentResidenceZI(?string $batimentResidenceZI): self
    {
        $this->batimentResidenceZI = $batimentResidenceZI;

        return $this;
    }

    public function getCommune(): ?string
    {
        return $this->commune;
    }

    public function setCommune(string $commune): self
    {
        $this->commune = $commune;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getCedex(): ?string
    {
        return $this->cedex;
    }

    public function setCedex(?string $cedex): self
    {
        $this->cedex = $cedex;

        return $this;
    }

    /**
     * @return Collection<int, Etudiant>
     */
    public function getEtudiants(): Collection
    {
        return $this->etudiants;
    }

    public function addEtudiant(Etudiant $etudiant): self
    {
        if (!$this->etudiants->contains($etudiant)) {
            $this->etudiants[] = $etudiant;
            $etudiant->setAdresse($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): self
    {
        if ($this->etudiants->removeElement($etudiant)) {
            // set the owning side to null (unless already changed)
            if ($etudiant->getAdresse() === $this) {
                $etudiant->setAdresse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Stage>
     */
    public function getStages(): Collection
    {
        return $this->stages;
    }

    public function addStage(Stage $stage): self
    {
        if (!$this->stages->contains($stage)) {
            $this->stages[] = $stage;
            $stage->setAdresse($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->stages->removeElement($stage)) {
            // set the owning side to null (unless already changed)
            if ($stage->getAdresse() === $this) {
                $stage->setAdresse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EtablissementEnseignement>
     */
    public function getEtablissementsEnseignement(): Collection
    {
        return $this->etablissementsEnseignement;
    }

    public function addEtablissementsEnseignement(EtablissementEnseignement $etablissementsEnseignement): self
    {
        if (!$this->etablissementsEnseignement->contains($etablissementsEnseignement)) {
            $this->etablissementsEnseignement[] = $etablissementsEnseignement;
            $etablissementsEnseignement->setAdresse($this);
        }

        return $this;
    }

    public function removeEtablissementsEnseignement(EtablissementEnseignement $etablissementsEnseignement): self
    {
        if ($this->etablissementsEnseignement->removeElement($etablissementsEnseignement)) {
            // set the owning side to null (unless already changed)
            if ($etablissementsEnseignement->getAdresse() === $this) {
                $etablissementsEnseignement->setAdresse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): self
    {
        if (!$this->services->contains($service)) {
            $this->services[] = $service;
            $service->setAdresse($this);
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getAdresse() === $this) {
                $service->setAdresse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Entreprise>
     */
    public function getEntreprises(): Collection
    {
        return $this->entreprises;
    }

    public function addEntreprise(Entreprise $entreprise): self
    {
        if (!$this->entreprises->contains($entreprise)) {
            $this->entreprises[] = $entreprise;
            $entreprise->setAdresse($this);
        }

        return $this;
    }

    public function removeEntreprise(Entreprise $entreprise): self
    {
        if ($this->entreprises->removeElement($entreprise)) {
            // set the owning side to null (unless already changed)
            if ($entreprise->getAdresse() === $this) {
                $entreprise->setAdresse(null);
            }
        }

        return $this;
    }
}
