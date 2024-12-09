<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImagesRepository::class)]
class Images
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $url = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?Apartments $apartments = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?Rooms $rooms = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;
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
}
