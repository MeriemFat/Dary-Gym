<?php

namespace App\Entity;

use App\Repository\ParticipationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParticipationRepository::class)
 */
class Participation
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
    private $nompart;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $usernamepart;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $numero;

    /**
     * @ORM\ManyToMany(targetEntity=Reservation::class, mappedBy="interet")
     */
    private $reservations;

    /**
     * @ORM\ManyToMany(targetEntity=Reservation::class, inversedBy="participations")
     */
    private $interet;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->interet = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getNompart(): ?string
    {
        return $this->nompart;
    }

    public function setNompart(string $nompart): self
    {
        $this->nompart = $nompart;

        return $this;
    }

    public function getUsernamepart(): ?string
    {
        return $this->usernamepart;
    }

    public function setUsernamepart(string $usernamepart): self
    {
        $this->usernamepart = $usernamepart;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->addInteret($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            $reservation->removeInteret($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getInteret(): Collection
    {
        return $this->interet;
    }

    public function addInteret(Reservation $interet): self
    {
        if (!$this->interet->contains($interet)) {
            $this->interet[] = $interet;
        }

        return $this;
    }

    public function removeInteret(Reservation $interet): self
    {
        $this->interet->removeElement($interet);

        return $this;
    }
}
