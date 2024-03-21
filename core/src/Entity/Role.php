<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
class Role
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    #[Groups(['office'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'roles'), ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    #[Groups(['office'])]
    private ?Hub $hub = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['office'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\NotNull, Assert\Range(min: -100, max: 100)]
    private ?int $priority = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHub(): ?Hub
    {
        return $this->hub;
    }

    public function setHub(?Hub $hub): static
    {
        $this->hub = $hub;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): static
    {
        $this->priority = $priority;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }


}
