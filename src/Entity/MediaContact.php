<?php

namespace App\Entity;

use App\Repository\MediaContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=MediaContactRepository::class)
 */
class MediaContact
{
    /**
     * @Groups("mediacontact")
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups("mediacontact")
     * @ORM\Column(type="string", length=30)
     */
    private $intitule;

    /**
     * @Groups("recherches_detail")
     * @ORM\OneToMany(targetEntity=Recherche::class, mappedBy="mediaContact")
     */
    private $recherches;

    public function __construct()
    {
        $this->recherches = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    /**
     * @return Collection<int, Recherche>
     */
    public function getRecherches(): Collection
    {
        return $this->recherches;
    }

    public function addRecherche(Recherche $recherche): self
    {
        if (!$this->recherches->contains($recherche)) {
            $this->recherches[] = $recherche;
            $recherche->setMediaContact($this);
        }

        return $this;
    }

    public function removeRecherche(Recherche $recherche): self
    {
        if ($this->recherches->removeElement($recherche)) {
            // set the owning side to null (unless already changed)
            if ($recherche->getMediaContact() === $this) {
                $recherche->setMediaContact(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->intitule;
    }
}
