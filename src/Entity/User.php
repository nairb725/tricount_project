<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
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
     * @ORM\ManyToMany(targetEntity=Tricount::class, mappedBy="Users")
     */
    private $tricounts;

    /**
     * @ORM\ManyToMany(targetEntity=Expense::class, mappedBy="users")
     */
    private $expenses;

    /**
     * @ORM\OneToMany(targetEntity=Expense::class, mappedBy="creator", orphanRemoval=true)
     */
    private $expense_owned;


    public function __construct()
    {
        $this->tricounts = new ArrayCollection();
        $this->expenses = new ArrayCollection();
        $this->expense_owned = new ArrayCollection();
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
            $expense->addUsers($this);
        }

        return $this;
    }

    public function removeExpense(Expense $expense): self
    {
        if ($this->expenses->removeElement($expense)) {
            $expense->removeUsers($this);
        }

        return $this;
    }

    /**
     * @return Collection|Expense[]
     */
    public function getExpenseOwned(): Collection
    {
        return $this->expense_owned;
    }

    public function addExpenseOwned(Expense $expenseOwned): self
    {
        if (!$this->expense_owned->contains($expenseOwned)) {
            $this->expense_owned[] = $expenseOwned;
            $expenseOwned->setCreator($this);
        }

        return $this;
    }

    public function removeExpenseOwned(Expense $expenseOwned): self
    {
        if ($this->expense_owned->removeElement($expenseOwned)) {
            // set the owning side to null (unless already changed)
            if ($expenseOwned->getCreator() === $this) {
                $expenseOwned->setCreator(null);
            }
        }

        return $this;
    }

}
