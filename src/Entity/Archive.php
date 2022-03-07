<?php

namespace App\Entity;

use App\Repository\ArchiveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass=ArchiveRepository::class)
 */
class Archive
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=255)

     */
    private $idarchive;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank( message="Votre nomarchive ne doit pas etre vide")
     */
    private $nomarchive;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank( message="Votre description ne doit pas etre vide")
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdarchive(): ?string
    {
        return $this->idarchive;
    }

    public function setIdarchive(?string $idarchive): self
    {
        $this->idarchive = $idarchive;

        return $this;
    }

    public function getNomarchive(): ?string
    {
        return $this->nomarchive;
    }

    public function setNomarchive(?string $nomarchive): self
    {
        $this->nomarchive = $nomarchive;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
