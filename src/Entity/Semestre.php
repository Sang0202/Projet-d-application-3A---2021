<?php

namespace App\Entity;

use App\Repository\SemestreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SemestreRepository::class)
 */
class Semestre
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
    private $num_sem;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumSem(): ?int
    {
        return $this->num_sem;
    }

    public function setNumSem(int $num_sem): self
    {
        $this->num_sem = $num_sem;

        return $this;
    }
}
