<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank( message="Votre name ne doit pas etre vide")
     */
    private $namepart;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank( message="Votre username ne doit pas etre vide")
     */
    private $usernamepart;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank( message="Votre ville ne doit pas etre vide")
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=8)
     * @Assert\NotBlank( message="Votre numéro de telephone ne doit pas etre vide")
     */
    private $numtelephonepart;

    /**
     * @ORM\ManyToMany(targetEntity=Participation::class, inversedBy="reservations")

     */
    private $interet;

    /**
     * @ORM\ManyToMany(targetEntity=Participation::class, mappedBy="interet")

     */
    private $participations;

    /**
     * @ORM\ManyToMany(targetEntity=Evenement::class, inversedBy="reservations")

     */
    private $tes;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $EmailParticipent;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reservations")
     */
    private $user;



    public function __construct()
    {
        $this->interet = new ArrayCollection();
        $this->participations = new ArrayCollection();
        $this->tes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNamepart(): ?string
    {
        return $this->namepart;
    }

    public function setNamepart(?string $namepart): self
    {
        $this->namepart = $namepart;

        return $this;
    }

    public function getUsernamepart(): ?string
    {
        return $this->usernamepart;
    }

    public function setUsernamepart(?string $usernamepart): self
    {
        $this->usernamepart = $usernamepart;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getNumtelephonepart(): ?string
    {
        return $this->numtelephonepart;
    }

    public function setNumtelephonepart(?string $numtelephonepart): self
    {
        $this->numtelephonepart = $numtelephonepart;

        return $this;
    }

    /**
     * @return Collection<int, Participation>
     */
    public function getInteret(): Collection
    {
        return $this->interet;
    }

    public function addInteret(Participation $interet): self
    {
        if (!$this->interet->contains($interet)) {
            $this->interet[] = $interet;
        }

        return $this;
    }

    public function removeInteret(Participation $interet): self
    {
        $this->interet->removeElement($interet);

        return $this;
    }

    /**
     * @return Collection<int, Participation>
     */
    public function getParticipations(): Collection
    {
        return $this->participations;
    }

    public function addParticipation(Participation $participation): self
    {
        if (!$this->participations->contains($participation)) {
            $this->participations[] = $participation;
            $participation->addInteret($this);
        }

        return $this;
    }

    public function removeParticipation(Participation $participation): self
    {
        if ($this->participations->removeElement($participation)) {
            $participation->removeInteret($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Evenement>
     */
    public function getTes(): Collection
    {
        return $this->tes;
    }

    public function addTe(Evenement $te): self
    {
        if (!$this->tes->contains($te)) {
            $this->tes[] = $te;
        }

        return $this;
    }

    public function removeTe(Evenement $te): self
    {
        $this->tes->removeElement($te);

        return $this;
    }

    public function getEmailParticipent(): ?string
    {
        return $this->EmailParticipent;
    }

    public function setEmailParticipent(string $EmailParticipent): self
    {
        $this->EmailParticipent = $EmailParticipent;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


}
