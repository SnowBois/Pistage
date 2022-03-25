<?php

namespace App\Entity;

use App\Repository\MediaContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MediaContactRepository::class)
 */
class MediaContact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomMedia;

    /**
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

    public function getNomMedia(): ?string
    {
        return $this->nomMedia;
    }

    public function setNomMedia(string $nomMedia): self
    {
        $this->nomMedia = $nomMedia;

        return $this;
    }

    /**
     * @return Collection<int, Recherche>
     */
    public function getRecherches(): Collection
    {
        return $this->recherches;
    }

    public function addRecherch(Recherche $recherch): self
    {
        if (!$this->recherches->contains($recherch)) {
            $this->recherches[] = $recherch;
            $recherch->setMediaContact($this);
        }

        return $this;
    }

    public function removeRecherch(Recherche $recherch): self
    {
        if ($this->recherches->removeElement($recherch)) {
            // set the owning side to null (unless already changed)
            if ($recherch->getMediaContact() === $this) {
                $recherch->setMediaContact(null);
            }
        }

        return $this;
    }
}
