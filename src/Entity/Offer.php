<?php

namespace App\Entity;

use App\Repository\OfferRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OfferRepository::class)]
class Offer extends AbstractPublishedEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $endProvidDate = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    private array $keyWords = [];

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $provide = null;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getEndProvidDate(): ?\DateTimeInterface
    {
        return $this->endProvidDate;
    }

    public function setEndProvidDate(\DateTimeInterface $endProvidDate): static
    {
        $this->endProvidDate = $endProvidDate;

        return $this;
    }

    public function getKeyWords(): array
    {
        return $this->keyWords;
    }

    public function setKeyWords(array $keyWords): static
    {
        $this->keyWords = $keyWords;

        return $this;
    }

    public function getProvide(): ?Company
    {
        return $this->provide;
    }

    public function setProvide(?Company $provide): static
    {
        $this->provide = $provide;

        return $this;
    }
}
