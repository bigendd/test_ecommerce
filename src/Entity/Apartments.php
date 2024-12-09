<?php

namespace App\Entity;

use App\Repository\ApartmentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApartmentsRepository::class)]
class Apartments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Rooms>
     */
    #[ORM\OneToMany(targetEntity: Rooms::class, mappedBy: 'apartments')]
    private Collection $rooms;

    /**
     * @var Collection<int, Images>
     */
    #[ORM\OneToMany(targetEntity: Images::class, mappedBy: 'apartments', cascade: ['persist'])]
    private Collection $images;

    /**
     * @var Collection<int, Avis>
     */
    #[ORM\OneToMany(targetEntity: Avis::class, mappedBy: 'Apartements')]
    private Collection $avis;

    /**
     * @var Collection<int, Booking>
     */
    #[ORM\OneToMany(targetEntity: Booking::class, mappedBy: 'appartements')]
    private Collection $bookings;

    /**
     * @var Collection<int, Paiments>
     */
    #[ORM\OneToMany(targetEntity: Paiments::class, mappedBy: 'apartments')]
    private Collection $paiments;

    // Ajout des nouvelles colonnes pour la réservation
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $address = null;

    #[ORM\Column(type: 'integer')]
    private ?int $price = null;

    #[ORM\Column(type: 'integer')]
    private ?int $maxGuests = null;

    #[ORM\Column(type: 'boolean')]
    private bool $isAvailable = true;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $availableFrom = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $availableUntil = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'appartement')]
    private ?Ville $ville = null;

    public function __construct()
    {
        $this->rooms = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->avis = new ArrayCollection();
        $this->bookings = new ArrayCollection();
        $this->paiments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRooms(): Collection
    {
        return $this->rooms;
    }

    public function addRoom(Rooms $room): static
    {
        if (!$this->rooms->contains($room)) {
            $this->rooms->add($room);
            $room->setApartments($this);
        }

        return $this;
    }

    public function removeRoom(Rooms $room): static
    {
        if ($this->rooms->removeElement($room)) {
            if ($room->getApartments() === $this) {
                $room->setApartments(null);
            }
        }

        return $this;
    }

    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setApartments($this);
        }

        return $this;
    }

    public function removeImage(Images $image): static
    {
        if ($this->images->removeElement($image)) {
            if ($image->getApartments() === $this) {
                $image->setApartments(null);
            }
        }

        return $this;
    }

    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): static
    {
        if (!$this->avis->contains($avi)) {
            $this->avis->add($avi);
            $avi->setApartements($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): static
    {
        if ($this->avis->removeElement($avi)) {
            if ($avi->getApartements() === $this) {
                $avi->setApartements(null);
            }
        }

        return $this;
    }

    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): static
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->setAppartements($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): static
    {
        if ($this->bookings->removeElement($booking)) {
            if ($booking->getAppartements() === $this) {
                $booking->setAppartements(null);
            }
        }

        return $this;
    }

    public function getPaiments(): Collection
    {
        return $this->paiments;
    }

    public function addPaiment(Paiments $paiment): static
    {
        if (!$this->paiments->contains($paiment)) {
            $this->paiments->add($paiment);
            $paiment->setApartments($this);
        }

        return $this;
    }

    public function removePaiment(Paiments $paiment): static
    {
        if ($this->paiments->removeElement($paiment)) {
            if ($paiment->getApartments() === $this) {
                $paiment->setApartments(null);
            }
        }

        return $this;
    }

    // Getters et setters pour les nouvelles colonnes
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;
        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;
        return $this;
    }

    public function getMaxGuests(): ?int
    {
        return $this->maxGuests;
    }

    public function setMaxGuests(int $maxGuests): static
    {
        $this->maxGuests = $maxGuests;
        return $this;
    }

    public function getIsAvailable(): bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): static
    {
        $this->isAvailable = $isAvailable;
        return $this;
    }

    public function getAvailableFrom(): ?\DateTimeInterface
    {
        return $this->availableFrom;
    }

    public function setAvailableFrom(\DateTimeInterface $availableFrom): static
    {
        $this->availableFrom = $availableFrom;
        return $this;
    }

    public function getAvailableUntil(): ?\DateTimeInterface
    {
        return $this->availableUntil;
    }

    public function setAvailableUntil(\DateTimeInterface $availableUntil): static
    {
        $this->availableUntil = $availableUntil;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): static
    {
        $this->ville = $ville;

        return $this;
    }
}
