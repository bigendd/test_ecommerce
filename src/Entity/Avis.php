<?php

namespace App\Entity;

use App\Repository\AvisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvisRepository::class)]
class Avis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'avis')]
    private ?User $userEntity = null;

    #[ORM\ManyToOne(inversedBy: 'avis')]
    private ?Apartments $Apartements = null;

    #[ORM\ManyToOne(inversedBy: 'avis')]
    private ?Rooms $rooms = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserEntity(): ?User
    {
        return $this->userEntity;
    }

    public function setUserEntity(?User $userEntity): static
    {
        $this->userEntity = $userEntity;

        return $this;
    }

    public function getApartements(): ?Apartments
    {
        return $this->Apartements;
    }

    public function setApartements(?Apartments $Apartements): static
    {
        $this->Apartements = $Apartements;

        return $this;
    }

    public function getRooms(): ?Rooms
    {
        return $this->rooms;
    }

    public function setRooms(?Rooms $rooms): static
    {
        $this->rooms = $rooms;

        return $this;
    }
}
