<?php
// src/Entity/Rooms.php
namespace App\Entity;

use App\Repository\RoomsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomsRepository::class)]
class Rooms
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Amenities>
     */
    #[ORM\ManyToMany(targetEntity: Amenities::class, inversedBy: 'rooms')]
    private Collection $amenities;

    #[ORM\ManyToOne(inversedBy: 'rooms')]
    private ?Apartments $apartments = null;



    /**
     * @var Collection<int, Avis>
     */
    #[ORM\OneToMany(targetEntity: Avis::class, mappedBy: 'rooms')]
    private Collection $avis;

    /**
     * @var Collection<int, Booking>
     */
    #[ORM\OneToMany(targetEntity: Booking::class, mappedBy: 'rooms')]
    private Collection $bookings;

    /**
     * @var Collection<int, Paiments>
     */
    #[ORM\OneToMany(targetEntity: Paiments::class, mappedBy: 'rooms')]
    private Collection $paiments;

    // Nouveau champ pour le prix de la chambre
    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?float $price = null;

    // Nouveau champ pour la date de début de réservation
    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $reservationStartDate = null;

    // Nouveau champ pour la date de fin de réservation
    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $reservationEndDate = null;

    // Nouveau champ pour la disponibilité
    #[ORM\Column(type: 'boolean')]
    private bool $isAvailable = true;

    #[ORM\ManyToOne(inversedBy: 'rooms')]
    private ?Ville $ville = null;

    public function __construct()
    {
        $this->amenities = new ArrayCollection();
        $this->avis = new ArrayCollection();
        $this->bookings = new ArrayCollection();
        $this->paiments = new ArrayCollection();
    }

    // Getters et setters pour les nouveaux champs

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Amenities>
     */
    public function getAmenities(): Collection
    {
        return $this->amenities;
    }

    public function addAmenity(Amenities $amenity): static
    {
        if (!$this->amenities->contains($amenity)) {
            $this->amenities->add($amenity);
        }

        return $this;
    }

    public function removeAmenity(Amenities $amenity): static
    {
        $this->amenities->removeElement($amenity);

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


    /**
     * @return Collection<int, Avis>
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): static
    {
        if (!$this->avis->contains($avi)) {
            $this->avis->add($avi);
            $avi->setRooms($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): static
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getRooms() === $this) {
                $avi->setRooms(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): static
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->setRooms($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): static
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getRooms() === $this) {
                $booking->setRooms(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Paiments>
     */
    public function getPaiments(): Collection
    {
        return $this->paiments;
    }

    public function addPaiment(Paiments $paiment): static
    {
        if (!$this->paiments->contains($paiment)) {
            $this->paiments->add($paiment);
            $paiment->setRooms($this);
        }

        return $this;
    }

    public function removePaiment(Paiments $paiment): static
    {
        if ($this->paiments->removeElement($paiment)) {
            // set the owning side to null (unless already changed)
            if ($paiment->getRooms() === $this) {
                $paiment->setRooms(null);
            }
        }

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getReservationStartDate(): ?\DateTimeInterface
    {
        return $this->reservationStartDate;
    }

    public function setReservationStartDate(?\DateTimeInterface $reservationStartDate): self
    {
        $this->reservationStartDate = $reservationStartDate;
        return $this;
    }

    public function getReservationEndDate(): ?\DateTimeInterface
    {
        return $this->reservationEndDate;
    }

    public function setReservationEndDate(?\DateTimeInterface $reservationEndDate): self
    {
        $this->reservationEndDate = $reservationEndDate;
        return $this;
    }

    public function getIsAvailable(): bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): self
    {
        $this->isAvailable = $isAvailable;
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
