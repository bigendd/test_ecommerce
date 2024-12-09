<?php

namespace App\Entity;

use App\Repository\VilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VilleRepository::class)]
class Ville
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $Name = null;

    /**
     * @var Collection<int, Rooms>
     */
    #[ORM\OneToMany(targetEntity: Rooms::class, mappedBy: 'ville')]
    private Collection $rooms;

    /**
     * @var Collection<int, Apartments>
     */
    #[ORM\OneToMany(targetEntity: Apartments::class, mappedBy: 'ville')]
    private Collection $appartement;

    public function __construct()
    {
        $this->rooms = new ArrayCollection();
        $this->appartement = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    /**
     * @return Collection<int, Rooms>
     */
    public function getRooms(): Collection
    {
        return $this->rooms;
    }

    public function addRoom(Rooms $room): static
    {
        if (!$this->rooms->contains($room)) {
            $this->rooms->add($room);
            $room->setVille($this);
        }

        return $this;
    }

    public function removeRoom(Rooms $room): static
    {
        if ($this->rooms->removeElement($room)) {
            // set the owning side to null (unless already changed)
            if ($room->getVille() === $this) {
                $room->setVille(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Apartments>
     */
    public function getAppartement(): Collection
    {
        return $this->appartement;
    }

    public function addAppartement(Apartments $appartement): static
    {
        if (!$this->appartement->contains($appartement)) {
            $this->appartement->add($appartement);
            $appartement->setVille($this);
        }

        return $this;
    }

    public function removeAppartement(Apartments $appartement): static
    {
        if ($this->appartement->removeElement($appartement)) {
            // set the owning side to null (unless already changed)
            if ($appartement->getVille() === $this) {
                $appartement->setVille(null);
            }
        }

        return $this;
    }
}
