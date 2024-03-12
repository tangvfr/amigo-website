<?php

namespace App\Entity;

use App\Repository\TestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestRepository::class)]
class Test
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $machin = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMachin(): ?string
    {
        return $this->machin;
    }

    public function setMachin(string $machin): static
    {
        $this->machin = $machin;

        return $this;
    }
}
