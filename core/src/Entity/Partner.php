<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Entity\Date\AbstractPublishableEntity;
use App\Entity\Date\BeginEndDateEmbeddable;
use App\Repository\PartnerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/challenger',
            normalizationContext: ['groups' => ['challengerCompany']],
            name: Partner::CHALLENGER_PARTNER,
        ),
        new GetCollection(
            uriTemplate: '/discount',
            normalizationContext: ['groups' => ['discountCompany']],
            name: Partner::DISCOUNT_PARTNER,
        ),
    ],
    routePrefix: 'partner',
    order: [
        'publicationDate' => 'desc',
        'bgedDate.beginDate' => 'desc',
        'bgedDate.endDate' => 'asc',
    ]
)]
#[ORM\Entity(repositoryClass: PartnerRepository::class)]
class Partner extends AbstractPublishableEntity
{
    const CHALLENGER_PARTNER = 'challenger';
    const DISCOUNT_PARTNER = 'discount';

    #[ORMId, ORMGeneratedValue, ORMColumn]
    #[Groups(['challengerCompany', 'discountCompany'])]
    private ?int $id = null;

    #[ORM\ManyToOne, ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    #[Groups(['challengerCompany', 'discountCompany'])]
    private ?Company $company = null;

    #[ORM\Column]
    #[Assert\NotNull]
    private ?bool $challenge = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotBlank(allowNull: true)]
    #[Groups(['discountCompany'])]
    private ?string $advantages = null;

    #[ORM\Embedded(class: BeginEndDateEmbeddable::class, columnPrefix: false)]
    #[Groups(['challengerCompany', 'discountCompany'])]
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
