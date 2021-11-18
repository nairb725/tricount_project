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
        $this->expenses = new ArrayCollection();
        $this->User_tricount = new ArrayCollection();
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
        return $this->User_tricount;
    }

    public function addUserTricount(User $userTricount): self
    {
        if (!$this->User_tricount->contains($userTricount)) {
            $this->User_tricount[] = $userTricount;
        }

        return $this;
    }

    public function removeUserTricount(User $userTricount): self
    {
        $this->User_tricount->removeElement($userTricount);

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
            $expense->setIdTricount($this);
        }

        return $this;
    }

    public function removeExpense(Expense $expense): self
    {
        if ($this->expenses->removeElement($expense)) {
            // set the owning side to null (unless already changed)
            if ($expense->getIdTricount() === $this) {
                $expense->setIdTricount(null);
            }
        }

        return $this;
    }
}
