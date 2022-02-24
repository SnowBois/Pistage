<?php

namespace App\Entity;

use App\Repository\EtablissementEnseignementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtablissementEnseignementRepository::class)
 */
class EtablissementEnseignement
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
    private $composanteUFR;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $disciplineEtDiplome;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $etapeEtude;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $numeroTelephone;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComposanteUFR(): ?string
    {
        return $this->composanteUFR;
    }

    public function setComposanteUFR(string $composanteUFR): self
    {
        $this->composanteUFR = $composanteUFR;

        return $this;
    }

    public function getDisciplineEtDiplome(): ?string
    {
        return $this->disciplineEtDiplome;
    }

    public function setDisciplineEtDiplome(string $disciplineEtDiplome): self
    {
        $this->disciplineEtDiplome = $disciplineEtDiplome;

        return $this;
    }

    public function getEtapeEtude(): ?string
    {
        return $this->etapeEtude;
    }

    public function setEtapeEtude(string $etapeEtude): self
    {
        $this->etapeEtude = $etapeEtude;

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
}
