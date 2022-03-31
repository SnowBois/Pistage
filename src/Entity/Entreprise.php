<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=EntrepriseRepository::class)
 */
class Entreprise
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $numeroTelephone;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $typeEtablissement;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $activite;

    /**
     * @ORM\Column(type="string", length=14)
     */
    private $numeroSIRET;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $codeAPEouNAF;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $statutJuridique;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $effectif;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $numeroFax;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $adresseMail;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $siteWeb;

    /**
     * @ORM\OneToMany(targetEntity=Employe::class, mappedBy="entreprise")
     */
    private $employes;

    /**
     * @ORM\OneToMany(targetEntity=Recherche::class, mappedBy="entreprise")
     */
    private $recherches;

    /**
     * @ORM\OneToMany(targetEntity=Service::class, mappedBy="entreprise", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $services;

    /**
     * @ORM\ManyToOne(targetEntity=Adresse::class, inversedBy="entreprises", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $adresse;

    public function __construct()
    {
        $this->employes = new ArrayCollection();
        $this->recherches = new ArrayCollection();
        $this->services = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNumeroTelephone(): ?string
    {
        return $this->numeroTelephone;
    }

    public function setNumeroTelephone(string $numeroTelephone): self
    {
        $this->numeroTelephone = $numeroTelephone;

        return $this;
    }

    public function getTypeEtablissement(): ?string
    {
        return $this->typeEtablissement;
    }

    public function setTypeEtablissement(string $typeEtablissement): self
    {
        $this->typeEtablissement = $typeEtablissement;

        return $this;
    }

    public function getActivite(): ?string
    {
        return $this->activite;
    }

    public function setActivite(string $activite): self
    {
        $this->activite = $activite;

        return $this;
    }

    public function getNumeroSIRET(): ?string
    {
        return $this->numeroSIRET;
    }

    public function setNumeroSIRET(string $numeroSIRET): self
    {
        $this->numeroSIRET = $numeroSIRET;

        return $this;
    }

    public function getCodeAPEouNAF(): ?string
    {
        return $this->codeAPEouNAF;
    }

    public function setCodeAPEouNAF(?string $codeAPEouNAF): self
    {
        $this->codeAPEouNAF = $codeAPEouNAF;

        return $this;
    }

    public function getStatutJuridique(): ?string
    {
        return $this->statutJuridique;
    }

    public function setStatutJuridique(?string $statutJuridique): self
    {
        $this->statutJuridique = $statutJuridique;

        return $this;
    }

    public function getEffectif(): ?string
    {
        return $this->effectif;
    }

    public function setEffectif(string $effectif): self
    {
        $this->effectif = $effectif;

        return $this;
    }

    public function getRepresentantLegal()
    {
        return $this->representantLegal;
    }

    public function setRepresentantLegal($representantLegal): self
    {
        $this->representantLegal = $representantLegal;

        return $this;
    }

    public function getNumeroFax(): ?string
    {
        return $this->numeroFax;
    }

    public function setNumeroFax(?string $numeroFax): self
    {
        $this->numeroFax = $numeroFax;

        return $this;
    }

    public function getAdresseMail(): ?string
    {
        return $this->adresseMail;
    }

    public function setAdresseMail(?string $adresseMail): self
    {
        $this->adresseMail = $adresseMail;

        return $this;
    }

    public function getSiteWeb(): ?string
    {
        return $this->siteWeb;
    }

    public function setSiteWeb(?string $siteWeb): self
    {
        $this->siteWeb = $siteWeb;

        return $this;
    }

    /**
     * @return Collection<int, Employe>
     */
    public function getEmployes(): Collection
    {
        return $this->employes;
    }

    public function addEmploye(Employe $employe): self
    {
        if (!$this->employes->contains($employe)) {
            $this->employes[] = $employe;
            $employe->setEntreprise($this);
        }

        return $this;
    }

    public function removeEmploye(Employe $employe): self
    {
        if ($this->employes->removeElement($employe)) {
            // set the owning side to null (unless already changed)
            if ($employe->getEntreprise() === $this) {
                $employe->setEntreprise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Recherche>
     */
    public function getRecherches(): Collection
    {
        return $this->recherches;
    }

    public function addRecherche(Recherche $recherche): self
    {
        if (!$this->recherches->contains($recherche)) {
            $this->recherches[] = $recherche;
            $recherche->setEntreprise($this);
        }

        return $this;
    }

    public function removeRecherche(Recherche $recherche): self
    {
        if ($this->recherches->removeElement($recherche)) {
            // set the owning side to null (unless already changed)
            if ($recherche->getEntreprise() === $this) {
                $recherche->setEntreprise(null);
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
            $service->setEntreprise($this);
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getEntreprise() === $this) {
                $service->setEntreprise(null);
            }
        }

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

    public function __toString(): string
    {
        return $this->nom;
    }
}
