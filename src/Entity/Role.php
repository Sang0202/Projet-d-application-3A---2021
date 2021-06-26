<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoleRepository::class)
 */
class Role
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
    private $nom_role;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="idrole")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity=departement::class, inversedBy="roles")
     */
    private $departement;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->departement = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomRole(): ?string
    {
        return $this->nom_role;
    }

    public function setNomRole(string $nom_role): self
    {
        $this->nom_role = $nom_role;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setIdrole($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getIdrole() === $this) {
                $user->setIdrole(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|departement[]
     */
    public function getDepartement(): Collection
    {
        return $this->departement;
    }

    public function addDepartement(departement $departement): self
    {
        if (!$this->departement->contains($departement)) {
            $this->departement[] = $departement;
        }

        return $this;
    }

    public function removeDepartement(departement $departement): self
    {
        $this->departement->removeElement($departement);

        return $this;
    }
}
