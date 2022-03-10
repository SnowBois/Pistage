<?php

namespace App\Entity;

use App\Repository\EtatRechercheRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtatRechercheRepository::class)
 */
class EtatRecherche
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
    private $etat;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
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
}
