<?php

namespace App\Entity;

use App\Repository\MatiereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MatiereRepository::class)
 */
class Matiere
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
    private $nom_mat;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $objectif_mat;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $intro_mat;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $contenu_mat;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="Matiere")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMat(): ?string
    {
        return $this->nom_mat;
    }

    public function setNomMat(string $nom_mat): self
    {
        $this->nom_mat = $nom_mat;

        return $this;
    }

    public function getObjectifMat(): ?string
    {
        return $this->objectif_mat;
    }

    public function setObjectifMat(string $objectif_mat): self
    {
        $this->objectif_mat = $objectif_mat;

        return $this;
    }

    public function getIntroMat(): ?string
    {
        return $this->intro_mat;
    }

    public function setIntroMat(?string $intro_mat): self
    {
        $this->intro_mat = $intro_mat;

        return $this;
    }

    public function getContenuMat(): ?string
    {
        return $this->contenu_mat;
    }

    public function setContenuMat(?string $contenu_mat): self
    {
        $this->contenu_mat = $contenu_mat;

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
            $user->addMatiere($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeMatiere($this);
        }

        return $this;
    }
}
