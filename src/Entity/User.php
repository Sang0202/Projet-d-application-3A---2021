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
    private $nom_user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom_user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Email_user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password_user;

    /**
     * @ORM\ManyToOne(targetEntity=Role::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $Role;

    /**
     * @ORM\ManyToMany(targetEntity=Module::class)
     */
    private $Module;

    /**
     * @ORM\ManyToMany(targetEntity=matiere::class)
     */
    private $Matiere;

    public function __construct()
    {
        $this->Module = new ArrayCollection();
        $this->Matiere = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomUser(): ?string
    {
        return $this->nom_user;
    }

    public function setNomUser(string $nom_user): self
    {
        $this->nom_user = $nom_user;

        return $this;
    }

    public function getPrenomUser(): ?string
    {
        return $this->prenom_user;
    }

    public function setPrenomUser(string $prenom_user): self
    {
        $this->prenom_user = $prenom_user;

        return $this;
    }

    public function getEmailUser(): ?string
    {
        return $this->Email_user;
    }

    public function setEmailUser(string $Email_user): self
    {
        $this->Email_user = $Email_user;

        return $this;
    }

    public function getPasswordUser(): ?string
    {
        return $this->password_user;
    }

    public function setPasswordUser(string $password_user): self
    {
        $this->password_user = $password_user;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->Role;
    }

    public function setRole(?Role $Role): self
    {
        $this->Role = $Role;

        return $this;
    }

    /**
     * @return Collection|Module[]
     */
    public function getModule(): Collection
    {
        return $this->Module;
    }

    public function addModule(Module $module): self
    {
        if (!$this->Module->contains($module)) {
            $this->Module[] = $module;
        }

        return $this;
    }

    public function removeModule(Module $module): self
    {
        $this->Module->removeElement($module);

        return $this;
    }

    /**
     * @return Collection|matiere[]
     */
    public function getMatiere(): Collection
    {
        return $this->Matiere;
    }

    public function addMatiere(matiere $matiere): self
    {
        if (!$this->Matiere->contains($matiere)) {
            $this->Matiere[] = $matiere;
        }

        return $this;
    }

    public function removeMatiere(matiere $matiere): self
    {
        $this->Matiere->removeElement($matiere);

        return $this;
    }
}
