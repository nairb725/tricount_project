<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */

 class Users implements UserInterface
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
    private $name;

    /**
     * @ORM\Column(type="string", length=180, unique=true, nullable=false)
     */
    private $email;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

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
     * @ORM\ManyToMany(targetEntity=Expenses::class, inversedBy="users")
     */
    private $user_expense;

    /**
     * @ORM\OneToMany(targetEntity=Expenses::class, mappedBy="Id_user", orphanRemoval=true)
     */
    private $expenses;

    public function __construct()
    {
        $this->tricounts = new ArrayCollection();
        $this->user_expense = new ArrayCollection();
        $this->expenses = new ArrayCollection();
    }

     public function __toString()
     {
         return $this->email;
     }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
     * @return Collection|Expenses[]
     */
    public function getUserExpense(): Collection
    {
        return $this->user_expense;
    }

    public function addUserExpense(Expenses $userExpense): self
    {
        if (!$this->user_expense->contains($userExpense)) {
            $this->user_expense[] = $userExpense;
        }

        return $this;
    }

    public function removeUserExpense(Expenses $userExpense): self
    {
        $this->user_expense->removeElement($userExpense);

        return $this;
    }

    /**
     * @return Collection|Expenses[]
     */
    public function getExpenses(): Collection
    {
        return $this->expenses;
    }

    public function addExpense(Expenses $expense): self
    {
        if (!$this->expenses->contains($expense)) {
            $this->expenses[] = $expense;
            $expense->setIdUser($this);
        }

        return $this;
    }

    public function removeExpense(Expenses $expense): self
    {
        if ($this->expenses->removeElement($expense)) {
            // set the owning side to null (unless already changed)
            if ($expense->getIdUser() === $this) {
                $expense->setIdUser(null);
            }
        }

        return $this;
    }

    public function getActivationToken(): ?string
    {
        return $this->activation_token;
    }

    public function setActivationToken(?string $activation_token): self
    {
        $this->activation_token = $activation_token;

        return $this;
    }

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

}
