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
     * @ORM\ManyToMany(targetEntity=Departement::class)
     */
    private $Departement;

    public function __construct()
    {
        $this->Departement = new ArrayCollection();
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
     * @return Collection|Departement[]
     */
    public function getDepartement(): Collection
    {
        return $this->Departement;
    }

    public function addDepartement(Departement $departement): self
    {
        if (!$this->Departement->contains($departement)) {
            $this->Departement[] = $departement;
        }

        return $this;
    }

    public function removeDepartement(Departement $departement): self
    {
        $this->Departement->removeElement($departement);

        return $this;
    }
}
