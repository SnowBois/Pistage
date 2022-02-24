<?php

namespace App\Entity;

use App\Repository\EmployeRepository;
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
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
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
    private $adMail;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $estRepresentantLegal;

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

    public function getAdMail(): ?string
    {
        return $this->adMail;
    }

    public function setAdMail(?string $adMail): self
    {
        $this->adMail = $adMail;

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
}
