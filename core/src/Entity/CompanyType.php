<?php

namespace App\Entity;

use App\Repository\CompanyTypeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CompanyTypeRepository::class)]
class CompanyType
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    #[Groups(['challengerCompany', 'discountCompany', 'infoCompany'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank]
    #[Groups(['challengerCompany', 'discountCompany', 'infoCompany'])]
    private ?string $label = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function __toString(): string
    {
        return $this->label;
    }
}
