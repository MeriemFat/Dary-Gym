<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"username"})
 * @UniqueEntity(fields={"email"})
 */
class User implements UserInterface, EquatableInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank( message="Ne doit pas être vide")
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Ne doit pas être vide")
     */
    private $nomComplet;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Assert\NotBlank(message="Ne doit pas être vide")
     * @Assert\Email(message="Email invalide")
     */
    private $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private $valid;

    /**
     * @ORM\Column(type="boolean")
     */
    private $deleted;

    /**
     * @ORM\Column(type="string", length=255))
     */
    private $password;



    

    /**
     * @ORM\Column(type="boolean")
     */
    private $admin;

    /**
     * @ORM\ManyToOne(targetEntity=Evenement::class, inversedBy="relation")
     */
    private $evenement;

    /**
     * @ORM\ManyToOne(targetEntity=Archive::class, inversedBy="img")
     */
    private $archive;

    /**
     * @ORM\OneToOne(targetEntity=Archive::class, cascade={"persist", "remove"})
     */
    //private $description;

    /**
     * @ORM\OneToOne(targetEntity=Evenement::class, cascade={"persist", "remove"})
     */
   // private $description;

    


    public function __construct()
    {
        $this->blogPosts = new ArrayCollection();
        $this->blogPostsCreated = new ArrayCollection();
        $this->historiques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername($username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed for apps that do not check user passwords
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNomComplet(): ?string
    {
        return $this->nomComplet;
    }

    public function setNomComplet( $nomComplet): self
    {
        $this->nomComplet = $nomComplet;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail( $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function isValid(): ?bool
    {
        return $this->valid;
    }

    public function setValid(bool $valid): self
    {
        $this->valid = $valid;

        return $this;
    }

    public function isDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function setPassword($password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getAvatarUrl($size){
        return "https://api.adorable.io/avatars/$size/".$this->username;
    }


    function getColorCode() {
        $code = dechex(crc32($this->getUsername()));
        $code = substr($code, 0, 6);
        return "#".$code;
    }

    /**
     * @Assert\Callback
     */

    public function validate(ExecutionContextInterface $context, $payload)
    {
        /*if (strlen($this->password)< 3){
            $context->buildViolation('Mot de passe trop court')
                ->atPath('justpassword')
                ->addViolation();
        }*/
    }

    // /**
    //  * @return Collection|BlogPost[]
    //  */
    // public function getBlogPosts(): Collection
    // {
    //     return $this->blogPosts;
    // }

    // public function addBlogPost(BlogPost $blogPost): self
    // {
    //     if (!$this->blogPosts->contains($blogPost)) {
    //         $this->blogPosts[] = $blogPost;
    //         $blogPost->setAuthor($this);
    //     }

    //     return $this;
    // }

    // public function removeBlogPost(BlogPost $blogPost): self
    // {
    //     if ($this->blogPosts->contains($blogPost)) {
    //         $this->blogPosts->removeElement($blogPost);
    //         // set the owning side to null (unless already changed)
    //         if ($blogPost->getAuthor() === $this) {
    //             $blogPost->setAuthor(null);
    //         }
    //     }

    //     return $this;
    // }

    // /**
    //  * @return Collection|BlogPost[]
    //  */
    // public function getBlogPostsCreated(): Collection
    // {
    //     return $this->blogPostsCreated;
    // }

    // public function addBlogPostsCreated(BlogPost $blogPostsCreated): self
    // {
    //     if (!$this->blogPostsCreated->contains($blogPostsCreated)) {
    //         $this->blogPostsCreated[] = $blogPostsCreated;
    //         $blogPostsCreated->setCreator($this);
    //     }

    //     return $this;
    // }

    // public function removeBlogPostsCreated(BlogPost $blogPostsCreated): self
    // {
    //     if ($this->blogPostsCreated->contains($blogPostsCreated)) {
    //         $this->blogPostsCreated->removeElement($blogPostsCreated);
    //         // set the owning side to null (unless already changed)
    //         if ($blogPostsCreated->getCreator() === $this) {
    //             $blogPostsCreated->setCreator(null);
    //         }
    //     }

    //     return $this;
    // }

    public function __toString()
    {
        return "$this->nomComplet ($this->id)";
    }

    public function isAdmin(): ?bool
    {
        return $this->admin;
    }

    public function setAdmin(bool $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

   


    public function isEqualTo(UserInterface $user)
    {
        if ($user instanceof User)
        return $this->isValid() && !$this->isDeleted() && $this->getPassword() == $user->getPassword() && $this->getUsername() == $user->getUsername()
            && $this->getEmail() == $user->getEmail() ;
    }

    public function getEvenement(): ?Evenement
    {
        return $this->evenement;
    }

    public function setEvenement(?Evenement $evenement): self
    {
        $this->evenement = $evenement;

        return $this;
    }

    public function getHistory(): ?History
    {
        return $this->history;
    }

    public function setHistory(?History $history): self
    {
        $this->history = $history;

        return $this;
    }

    public function getDescrription(): ?History
    {
        return $this->descrription;
    }

    public function setDescrription(?History $descrription): self
    {
        $this->descrription = $descrription;

        return $this;
    }

    public function getDescription(): ?Evenement
    {
        return $this->description;
    }

    public function setDescription(?Evenement $description): self
    {
        $this->description = $description;

        return $this;
    }
}
