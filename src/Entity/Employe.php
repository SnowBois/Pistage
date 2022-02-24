<?php

namespace App\Entity;

use App\Repository\EmployeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmployeRepository::class)
 */
class Employe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $fonction;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $numeroTelephone;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $adresseMail;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $estRepresentantLegal;

    /**
     * @ORM\OneToMany(targetEntity=Recherche::class, mappedBy="interlocuteur")
     */
    private $recherches;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="employes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $entreprise;

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

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(?string $fonction): self
    {
        $this->fonction = $fonction;

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

    public function setAdresseMail(?string $adresseMail): self
    {
        $this->adresseMail = $adresseMail;

        return $this;
    }

    public function getEstRepresentantLegal(): ?bool
    {
        return $this->estRepresentantLegal;
    }

    public function setEstRepresentantLegal(?bool $estRepresentantLegal): self
    {
        $this->estRepresentantLegal = $estRepresentantLegal;

        return $this;
    }

    /**
     * @return Collection<int, Recherche>
     */
    public function getRecherches(): Collection
    {
        return $this->recherches;
    }

    public function addRecherch(Recherche $recherch): self
    {
        if (!$this->recherches->contains($recherch)) {
            $this->recherches[] = $recherch;
            $recherch->setInterlocuteur($this);
        }

        return $this;
    }

    public function removeRecherch(Recherche $recherch): self
    {
        if ($this->recherches->removeElement($recherch)) {
            // set the owning side to null (unless already changed)
            if ($recherch->getInterlocuteur() === $this) {
                $recherch->setInterlocuteur(null);
            }
        }

        return $this;
    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }
}
