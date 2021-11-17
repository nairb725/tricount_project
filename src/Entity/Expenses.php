<?php

namespace App\Entity;

use App\Repository\ExpensesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExpensesRepository::class)
 */
class Expenses
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
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\ManyToMany(targetEntity=Users::class, mappedBy="user_expense")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="expenses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Id_user;

    /**
     * @ORM\ManyToOne(targetEntity=Tricount::class, inversedBy="expenses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Id_tricount;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|Users[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(Users $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addUserExpense($this);
        }

        return $this;
    }

    public function removeUser(Users $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeUserExpense($this);
        }

        return $this;
    }

    public function getIdUser(): ?Users
    {
        return $this->Id_user;
    }

    public function setIdUser(?Users $Id_user): self
    {
        $this->Id_user = $Id_user;

        return $this;
    }

    public function getIdTricount(): ?Tricount
    {
        return $this->Id_tricount;
    }

    public function setIdTricount(?Tricount $Id_tricount): self
    {
        $this->Id_tricount = $Id_tricount;

        return $this;
    }
}
