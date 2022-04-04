<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ServiceRepository::class)
 */
class Service
{
    /**
     * @Groups("service_sans_entreprise")
     * @Groups("service")
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups("service_sans_entreprise")
     * @Groups("service")
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @Groups("service")
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="services")
     * @ORM\JoinColumn(nullable=false)
     */
    private $entreprise;

    /**
     * @Groups("service_sans_entreprise")
     * @Groups("service")
     * @ORM\ManyToOne(targetEntity=Adresse::class, inversedBy="services", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $adresse;

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

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;

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
        return $this->nom;
    }
}
