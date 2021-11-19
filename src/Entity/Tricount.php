<?php

namespace App\Entity;

use App\Repository\TricountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TricountRepository::class)
 */
class Tricount
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="tricounts")
     */
    private $Users;

    /**
     * @ORM\Column(type="string", length=11)
     */
    private $currency = "EUR";

    /**
     * @ORM\OneToMany(targetEntity=Expense::class, mappedBy="tricount", orphanRemoval=true)
     */
    private $expenses;

    public function __construct()
    {
        $this->expenses = new ArrayCollection();
        $this->Users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    /**
     * @return Collection|User[]
     */
    public function getUserTricount(): Collection
    {
        return $this->Users;
    }

    public function addUserTricount(User $userTricount): self
    {
        if (!$this->Users->contains($userTricount)) {
            $this->Users[] = $userTricount;
        }

        return $this;
    }

    public function removeUserTricount(User $userTricount): self
    {
        $this->Users->removeElement($userTricount);

        return $this;
    }


    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

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
            $expense->setTricount($this);
        }

        return $this;
    }

    public function removeExpense(Expense $expense): self
    {
        if ($this->expenses->removeElement($expense)) {
            // set the owning side to null (unless already changed)
            if ($expense->getTricount() === $this) {
                $expense->setTricount(null);
            }
        }

        return $this;
    }
}
