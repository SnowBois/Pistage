<?php

namespace App\Entity;

use App\Repository\EtablissementEnseignementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=EtablissementEnseignementRepository::class)
 */
class EtablissementEnseignement
{
    /**
     * @Groups("etablissementenseignement")
     * @Groups("etablissementenseignement_sans_stages")
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups("etablissementenseignement")
     * @Groups("etablissementenseignement_sans_stages")
     * @ORM\Column(type="string", length=50)
     */
    private $composanteUFR;

    /**
     * @Groups("etablissementenseignement")
     * @Groups("etablissementenseignement_sans_stages")
     * @ORM\Column(type="string", length=30)
     */
    private $disciplineEtDiplome;

    /**
     * @Groups("etablissementenseignement")
     * @Groups("etablissementenseignement_sans_stages")
     * @ORM\Column(type="string", length=30)
     */
    private $etapeEtude;

    /**
     * @Groups("etablissementenseignement")
     * @Groups("etablissementenseignement_sans_stages")
     * @ORM\Column(type="string", length=20)
     */
    private $numeroTelephone;

    /**
     * @Groups("etablissementenseignement")
     * @ORM\OneToMany(targetEntity=Stage::class, mappedBy="etablissementEnseignement")
     */
    private $stages;

    /**
     * @Groups("etablissementenseignement")
     * @Groups("etablissementenseignement_sans_stages")
     * @ORM\ManyToOne(targetEntity=Adresse::class, inversedBy="etablissementsEnseignement")
     * @ORM\JoinColumn(nullable=false)
     */
    private $adresse;

    public function __construct()
    {
        $this->stages = new ArrayCollection();
    }

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
            $stage->setEtablissementEnseignement($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->stages->removeElement($stage)) {
            // set the owning side to null (unless already changed)
            if ($stage->getEtablissementEnseignement() === $this) {
                $stage->setEtablissementEnseignement(null);
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
        return $this->composanteUFR;
    }
}
