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
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $Email_user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password_user;

    /**
     * @ORM\ManyToOne(targetEntity=Role::class, inversedBy="users")
     */
    private $idrole;

    /**
     * @ORM\ManyToOne(targetEntity=role::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $Idrole;

    /**
     * @ORM\ManyToMany(targetEntity=Module::class, inversedBy="users")
     */
    private $User;

    /**
     * @ORM\ManyToMany(targetEntity=matiere::class, inversedBy="users")
     */
    private $Matiere;

    /**
     * @ORM\ManyToOne(targetEntity=Departement::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $iduser;

    public function __construct()
    {
        $this->User = new ArrayCollection();
        $this->Matiere = new ArrayCollection();
    }

    /**
     * @ORM\Column(type="string", length=255)
     */
   

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

    public function getIdrole(): ?role
    {
        return $this->Idrole;
    }

    public function setIdrole(?role $Idrole): self
    {
        $this->Idrole = $Idrole;

        return $this;
    }

    /**
     * @return Collection|Module[]
     */
    public function getUser(): Collection
    {
        return $this->User;
    }

    public function addUser(Module $user): self
    {
        if (!$this->User->contains($user)) {
            $this->User[] = $user;
        }

        return $this;
    }

    public function removeUser(Module $user): self
    {
        $this->User->removeElement($user);

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

    public function getIduser(): ?Departement
    {
        return $this->iduser;
    }

    public function setIduser(?Departement $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }

    

   

  

   
}
