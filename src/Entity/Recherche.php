<?php

namespace App\Entity;

use App\Repository\RechercheRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RechercheRepository::class)
 */
class Recherche
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
    private $mediaContact;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $observations;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMediaContact(): ?string
    {
        return $this->mediaContact;
    }

    public function setMediaContact(string $mediaContact): self
    {
        $this->mediaContact = $mediaContact;

        return $this;
    }

    public function getObservations(): ?string
    {
        return $this->observations;
    }

    public function setObservations(?string $observations): self
    {
        $this->observations = $observations;

        return $this;
    }
}
