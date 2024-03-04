<?php

namespace App\Entity;

use App\Entity\Date\AbstractPublishableEntity;
use App\Entity\Date\BeginEndDateEmbeddable;
use App\Repository\PartnerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartnerRepository::class)]
class Partner extends AbstractPublishableEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    #[ORM\Column]
    private ?bool $challenge = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $advantages = null;

    #[ORM\Embedded(class: BeginEndDateEmbeddable::class, columnPrefix: false)]
    private BeginEndDateEmbeddable $bgedDate;

    public function __construct()
    {
        $this->bgedDate = new BeginEndDateEmbeddable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function isChallenge(): ?bool
    {
        return $this->challenge;
    }

    public function setChallenge(bool $challenge): static
    {
        $this->challenge = $challenge;

        return $this;
    }

    public function getAdvantages(): ?string
    {
        return $this->advantages;
    }

    public function setAdvantages(?string $advantages): static
    {
        $this->advantages = $advantages;

        return $this;
    }

    public function getBgedDate(): BeginEndDateEmbeddable
    {
        return $this->bgedDate;
    }

    public function setBgedDate(BeginEndDateEmbeddable $bgedDate): static
    {
        $this->bgedDate = $bgedDate;

        return $this;
    }

}
