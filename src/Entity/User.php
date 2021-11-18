<?php

namespace App\Entity;

use App\Repository\UserRepository;
<<<<<<< HEAD
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
=======
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
<<<<<<<< HEAD:src/Entity/User.php
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
========
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */

 class Users implements UserInterface
>>>>>>>> 7922e880e0791ae7043d91d4b601d32d5d5efdab:src/Entity/Users.php
>>>>>>> 7922e880e0791ae7043d91d4b601d32d5d5efdab
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
<<<<<<< HEAD
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];
=======
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=180, unique=true, nullable=false)
     */
    private $email;
>>>>>>> 7922e880e0791ae7043d91d4b601d32d5d5efdab

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

<<<<<<< HEAD
=======
     /**
      * @ORM\Column(type="json")
      */
     private $roles = [];

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $activation_token;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $reset_token;

    /**
     * @ORM\ManyToMany(targetEntity=Tricount::class, mappedBy="User_tricount")
     */
    private $tricounts;

    /**
     * @ORM\ManyToMany(targetEntity=Expense::class, mappedBy="id_user")
     */
    private $expenses;


    public function __construct()
    {
        $this->tricounts = new ArrayCollection();
        $this->expenses = new ArrayCollection();
    }

     public function __toString()
     {
         return $this->email;
     }

>>>>>>> 7922e880e0791ae7043d91d4b601d32d5d5efdab
    public function getId(): ?int
    {
        return $this->id;
    }

<<<<<<< HEAD
=======
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

>>>>>>> 7922e880e0791ae7043d91d4b601d32d5d5efdab
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

<<<<<<< HEAD
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
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
=======
     /**
      * @see UserInterface
      */
     public function getPassword(): string
     {
         return (string) $this->password;
     }

     public function setPassword(string $password): self
     {
         $this->password = $password;

         return $this;
     }

    /**
     * @return Collection|Tricount[]
     */
    public function getTricounts(): Collection
    {
        return $this->tricounts;
    }

    public function addTricount(Tricount $tricount): self
    {
        if (!$this->tricounts->contains($tricount)) {
            $this->tricounts[] = $tricount;
            $tricount->addUserTricount($this);
        }

        return $this;
    }

    public function removeTricount(Tricount $tricount): self
    {
        if ($this->tricounts->removeElement($tricount)) {
            $tricount->removeUserTricount($this);
        }

        return $this;
    }

    /**
     * @return Collection|Expense[]
     */
    public function getExpenses(): Collection
    {
        return $this->expenses;
    }

    public function addExpense(Expense $expense): self
    {
        if (!$this->expenses->contains($expense)) {
            $this->expenses[] = $expense;
            $expense->addIdUser($this);
        }

        return $this;
    }

    public function removeExpense(Expense $expense): self
    {
        if ($this->expenses->removeElement($expense)) {
            $expense->removeIdUser($this);
        }
>>>>>>> 7922e880e0791ae7043d91d4b601d32d5d5efdab

        return $this;
    }

<<<<<<< HEAD
    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
=======
<<<<<<<< HEAD:src/Entity/User.php
========
    public function getActivationToken(): ?string
    {
        return $this->activation_token;
    }

    public function setActivationToken(?string $activation_token): self
    {
        $this->activation_token = $activation_token;
>>>>>>> 7922e880e0791ae7043d91d4b601d32d5d5efdab

        return $this;
    }

<<<<<<< HEAD
    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
=======
    public function getResetToken(): ?string
    {
        return $this->reset_token;
    }

    public function setResetToken(?string $reset_token): self
    {
        $this->reset_token = $reset_token;

        return $this;
    }

     /**
      * A visual identifier that represents this user.
      *
      * @see UserInterface
      */
     public function getUsername(): string
     {
         return (string) $this->email;
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
     public function getSalt()
     {
         // not needed when using the "bcrypt" algorithm in security.yaml
     }

     /**
      * @see UserInterface
      */
     public function eraseCredentials()
     {
         // If you store any temporary, sensitive data on the user, clear it here
         // $this->plainPassword = null;
     }

>>>>>>>> 7922e880e0791ae7043d91d4b601d32d5d5efdab:src/Entity/Users.php
>>>>>>> 7922e880e0791ae7043d91d4b601d32d5d5efdab
}
