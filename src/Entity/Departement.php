<?php

namespace App\Entity;

use App\Repository\DepartementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DepartementRepository::class)
 */
class Departement
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
    private $nom_dep;

    /**
     * @ORM\ManyToMany(targetEntity=Role::class, mappedBy="departement")
     */
    private $roles;

    /**
     * @ORM\ManyToMany(targetEntity=Annee::class, inversedBy="departements")
     */
    private $Annee;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->Annee = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDep(): ?string
    {
        return $this->nom_dep;
    }

    public function setNomDep(string $nom_dep): self
    {
        $this->nom_dep = $nom_dep;

        return $this;
    }

    /**
     * @return Collection|Role[]
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function addRole(Role $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
            $role->addDepartement($this);
        }

        return $this;
    }

    public function removeRole(Role $role): self
    {
        if ($this->roles->removeElement($role)) {
            $role->removeDepartement($this);
        }

        return $this;
    }

    /**
     * @return Collection|Annee[]
     */
    public function getAnnee(): Collection
    {
        return $this->Annee;
    }

    public function addAnnee(Annee $annee): self
    {
        if (!$this->Annee->contains($annee)) {
            $this->Annee[] = $annee;
        }

        return $this;
    }

    public function removeAnnee(Annee $annee): self
    {
        $this->Annee->removeElement($annee);

        return $this;
    }
}
