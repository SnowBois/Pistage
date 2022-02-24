<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
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
}
