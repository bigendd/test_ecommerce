<?php
// src/Entity/Booking.php
namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    private ?User $userEntity = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    private ?Apartments $appartements = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    private ?Rooms $rooms = null;

    /**
     * @var Collection<int, Paiments>
     */
    #[ORM\OneToMany(targetEntity: Paiments::class, mappedBy: 'booking')]
    private Collection $paiments;

    // Nouveau champ pour la date de début de réservation
    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $startDate = null;

    // Nouveau champ pour la date de fin de réservation
    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $endDate = null;

    // Nouveau champ pour le montant total payé pour la réservation
    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?float $totalAmount = null;

    public function __construct()
    {
        $this->paiments = new ArrayCollection();
    }

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

    public function getAppartements(): ?Apartments
    {
        return $this->appartements;
    }

    public function setAppartements(?Apartments $appartements): static
    {
        $this->appartements = $appartements;

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
            $paiment->setBooking($this);
        }

        return $this;
    }

    public function removePaiment(Paiments $paiment): static
    {
        if ($this->paiments->removeElement($paiment)) {
            // set the owning side to null (unless already changed)
            if ($paiment->getBooking() === $this) {
                $paiment->setBooking(null);
            }
        }

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getTotalAmount(): ?float
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(float $totalAmount): static
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }
}
