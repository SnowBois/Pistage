<?php

namespace App\Entity;

use App\Repository\EtudiantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=EtudiantRepository::class)
 */
class Etudiant
{
    /**
     * @Groups("etudiant")
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups("etudiant")
     * @ORM\Column(type="string", length=30)
     */
    private $nom;

    /**
     * @Groups("etudiant")
     * @ORM\Column(type="string", length=30)
     */
    private $prenom;

    /**
     * @Groups("etudiant")
     * @ORM\Column(type="string", length=10)
     */
    private $numeroEtudiant;

    /**
     * @Groups("etudiant")
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $numeroTelephone;

    /**
     * @Groups("etudiant")
     * @ORM\Column(type="string", length=100)
     */
    private $adresseMail;

    /**
     * @Groups("etudiant")
     * @ORM\Column(type="boolean")
     */
    private $premiereConnexion;

    /**
     * @ORM\OneToMany(targetEntity=Recherche::class, mappedBy="etudiant")
     */
    private $recherches;

    /**
     * @Groups("etudiant")
     * @ORM\ManyToOne(targetEntity=Cursus::class, inversedBy="etudiants", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $cursus;

    /**
     * @Groups("etudiant")
     * @ORM\ManyToOne(targetEntity=Adresse::class, inversedBy="etudiants", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $adresse;

    /**
     * @ORM\OneToOne(targetEntity=Utilisateur::class, inversedBy="etudiant", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $utilisateur;

    public function __construct()
    {
        $this->recherches = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNumeroEtudiant(): ?string
    {
        return $this->numeroEtudiant;
    }

    public function setNumeroEtudiant(string $numeroEtudiant): self
    {
        $this->numeroEtudiant = $numeroEtudiant;

        return $this;
    }

    public function getNumeroTelephone(): ?string
    {
        return $this->numeroTelephone;
    }

    public function setNumeroTelephone(?string $numeroTelephone): self
    {
        $this->numeroTelephone = $numeroTelephone;

        return $this;
    }

    public function getAdresseMail(): ?string
    {
        return $this->adresseMail;
    }

    public function setAdresseMail(string $adresseMail): self
    {
        $this->adresseMail = $adresseMail;

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
            $recherche->setEtudiant($this);
        }

        return $this;
    }

    public function removeRecherche(Recherche $recherche): self
    {
        if ($this->recherches->removeElement($recherche)) {
            // set the owning side to null (unless already changed)
            if ($recherche->getEtudiant() === $this) {
                $recherche->setEtudiant(null);
            }
        }

        return $this;
    }

    public function getCursus(): ?Cursus
    {
        return $this->cursus;
    }

    public function setCursus(?Cursus $cursus): self
    {
        $this->cursus = $cursus;

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

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getNomComplet(): ?string 
    {
        return $this->getPrenom() . ' ' . $this->getNom();
    }

    public function getPremiereConnexion(): ?bool
    {
        return $this->premiereConnexion;
    }

    public function setPremiereConnexion(bool $premiereConnexion): self
    {
        $this->premiereConnexion = $premiereConnexion;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getNomComplet();
    }
}
