<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 */
class Users
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
     * @ORM\Column(type="string", length=255)
     */
    private $password;

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

    public function getPassword(): ?string
    {
        return $this->password;
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
}
