<?php

namespace App\Entity;

use App\Repository\CursusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CursusRepository::class)
 */
class Cursus
{
    /**
     * @Groups("cursus")
     * @Groups("cursus_sans_etudiants")
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups("cursus")
     * @Groups("cursus_sans_etudiants")
     * @ORM\Column(type="text")
     */
    private $nomLong;

    /**
     * @Groups("cursus")
     * @Groups("cursus_sans_etudiants")
     * @ORM\Column(type="string", length=20)
     */
    private $nomCourt;

    /**
     * @Groups("cursus")
     * @ORM\OneToMany(targetEntity=Etudiant::class, mappedBy="cursus")
     */
    private $etudiants;

    public function __construct()
    {
        $this->etudiants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomLong(): ?string
    {
        return $this->nomLong;
    }

    public function setNomLong(string $nomLong): self
    {
        $this->nomLong = $nomLong;

        return $this;
    }

    public function getNomCourt(): ?string
    {
        return $this->nomCourt;
    }

    public function setNomCourt(string $nomCourt): self
    {
        $this->nomCourt = $nomCourt;

        return $this;
    }

    /**
     * @return Collection<int, Etudiant>
     */
    public function getEtudiants(): Collection
    {
        return $this->etudiants;
    }

    public function addEtudiant(Etudiant $etudiant): self
    {
        if (!$this->etudiants->contains($etudiant)) {
            $this->etudiants[] = $etudiant;
            $etudiant->setCursus($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): self
    {
        if ($this->etudiants->removeElement($etudiant)) {
            // set the owning side to null (unless already changed)
            if ($etudiant->getCursus() === $this) {
                $etudiant->setCursus(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getNomLong();
    }
}
