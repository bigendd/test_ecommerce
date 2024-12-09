<?php

namespace App\Entity;

use App\Repository\PaimentsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaimentsRepository::class)]
class Paiments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'paiments')]
    private ?User $userEntity = null;

    #[ORM\ManyToOne(inversedBy: 'paiments')]
    private ?Apartments $apartments = null;

    #[ORM\ManyToOne(inversedBy: 'paiments')]
    private ?Rooms $rooms = null;

    #[ORM\ManyToOne(inversedBy: 'paiments')]
    private ?Booking $booking = null;

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

    public function getApartments(): ?Apartments
    {
        return $this->apartments;
    }

    public function setApartments(?Apartments $apartments): static
    {
        $this->apartments = $apartments;

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

    public function getBooking(): ?Booking
    {
        return $this->booking;
    }

    public function setBooking(?Booking $booking): static
    {
        $this->booking = $booking;

        return $this;
    }
}
