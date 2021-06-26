<?php

namespace App\Entity;

use App\Repository\AnneeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnneeRepository::class)
 */
class Annee
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $num_annee;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumAnnee(): ?int
    {
        return $this->num_annee;
    }

    public function setNumAnnee(int $num_annee): self
    {
        $this->num_annee = $num_annee;

        return $this;
    }
}
