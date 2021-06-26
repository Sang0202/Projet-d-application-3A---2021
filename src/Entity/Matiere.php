<?php

namespace App\Entity;

use App\Repository\MatiereRepository;
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
     * @ORM\ManyToOne(targetEntity=Module::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $Module;

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

    public function setObjectifMat(?string $objectif_mat): self
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

    public function getModule(): ?Module
    {
        return $this->Module;
    }

    public function setModule(?Module $Module): self
    {
        $this->Module = $Module;

        return $this;
    }
}
