<?php

namespace App\Entity;

use App\Repository\EtatRechercheRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=EtatRechercheRepository::class)
 */
class EtatRecherche
{
    /**
     * @Groups("etatrecherche")
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups("etatrecherche")
     * @ORM\Column(type="string", length=30)
     */
    private $etat;

    /**
     * @Groups("etatrecherche")
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @Groups("recherche_detail")
     * @ORM\ManyToOne(targetEntity=Recherche::class, inversedBy="etatsRecherche")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $recherche;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getRecherche(): ?Recherche
    {
        return $this->recherche;
    }

    public function setRecherche(?Recherche $recherche): self
    {
        $this->recherche = $recherche;

        return $this;
    }

    public function __toString(): string
    {
        return $this->etat . " " . $this->date->format('d/m/Y H:i:s');
    }
}
