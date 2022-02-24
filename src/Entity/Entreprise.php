<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
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
     * @ORM\Column(type="string", length=15)
     */
    private $numeroTelephone;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $typeEtablissement;

    /**
     * @ORM\Column(type="text")
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
     * @ORM\Column(type="integer")
     */
    private $effectif;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
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

    public function getEffectif(): ?int
    {
        return $this->effectif;
    }

    public function setEffectif(int $effectif): self
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
}
