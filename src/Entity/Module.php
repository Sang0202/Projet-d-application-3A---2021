<?php

namespace App\Entity;

use App\Repository\ModuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ModuleRepository::class)
 */
class Module
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
    private $nom_mod;

    /**
     * @ORM\ManyToMany(targetEntity=Semestre::class)
     */
    private $Semestre;

    public function __construct()
    {
        $this->Semestre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMod(): ?string
    {
        return $this->nom_mod;
    }

    public function setNomMod(string $nom_mod): self
    {
        $this->nom_mod = $nom_mod;

        return $this;
    }

    /**
     * @return Collection|Semestre[]
     */
    public function getSemestre(): Collection
    {
        return $this->Semestre;
    }

    public function addSemestre(Semestre $semestre): self
    {
        if (!$this->Semestre->contains($semestre)) {
            $this->Semestre[] = $semestre;
        }

        return $this;
    }

    public function removeSemestre(Semestre $semestre): self
    {
        $this->Semestre->removeElement($semestre);

        return $this;
    }
}
