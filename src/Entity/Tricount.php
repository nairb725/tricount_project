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
     * @ORM\ManyToMany(targetEntity=Users::class, inversedBy="tricounts")
     */
    private $User_tricount;

    /**
     * @ORM\Column(type="string", length=11)
     */
    private $currency;

    /**
     * @ORM\OneToMany(targetEntity=Expense::class, mappedBy="id_tricount", orphanRemoval=true)
     */
    private $expenses;

    public function __construct()
    {
        $this->User_tricount = new ArrayCollection();
        $this->expenses = new ArrayCollection();
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
     * @return Collection|Users[]
     */
    public function getUserTricount(): Collection
    {
        return $this->User_tricount;
    }

    public function addUserTricount(Users $userTricount): self
    {
        if (!$this->User_tricount->contains($userTricount)) {
            $this->User_tricount[] = $userTricount;
        }

        return $this;
    }

    public function removeUserTricount(Users $userTricount): self
    {
        $this->User_tricount->removeElement($userTricount);

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
            $expense->setIdTricount($this);
        }

        return $this;
    }

    public function removeExpense(Expenses $expense): self
    {
        if ($this->expenses->removeElement($expense)) {
            // set the owning side to null (unless already changed)
            if ($expense->getIdTricount() === $this) {
                $expense->setIdTricount(null);
            }
        }

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
}
