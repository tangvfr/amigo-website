<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Common\Filter\DateFilterInterface;
use ApiPlatform\Doctrine\Common\Filter\SearchFilterInterface;
use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\GetCollection;
use App\Entity\Date\AbstractPublishableEntity;
use App\Entity\Date\BeginEndDateEmbeddable;
use App\Repository\OfferRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

#[GetCollection(
    order: [
        'publicationDate' => 'desc',
        'bgedDate.beginDate' => 'desc',
    ],
    normalizationContext: ['groups' => 'listOffer']
)]
#[ApiFilter(
    SearchFilter::class,
    properties: [
        'label' => SearchFilterInterface::STRATEGY_IPARTIAL,
        'keyWords' => SearchFilterInterface::STRATEGY_IPARTIAL,
        'provide.name' => SearchFilterInterface::STRATEGY_IPARTIAL,
        'provide.activities.label' => SearchFilterInterface::STRATEGY_IPARTIAL
    ]
)]
#[ApiFilter(
    DateFilter::class,
    properties: [
        'bgedDate.beginDate' => DateFilterInterface::INCLUDE_NULL_AFTER,
        'bgedDate.endDate' => DateFilterInterface::INCLUDE_NULL_BEFORE,
        'endProvidDate' => DateFilterInterface::INCLUDE_NULL_BEFORE_AND_AFTER,
    ]
)]
#[ORM\Entity(repositoryClass: OfferRepository::class)]
class Offer extends AbstractPublishableEntity
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    #[Groups(['listOffer'])]
    #[NotNull]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['listOffer'])]
    #[NotBlank]
    private ?string $label = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['listOffer'])]
    #[NotBlank]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['listOffer'])]
    #[NotNull]
    private ?DateTimeInterface $endProvidDate = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    #[Groups(['listOffer'])]
    private array $keyWords = [];

    #[ORM\ManyToOne, ORM\JoinColumn(nullable: false)]
    #[Groups(['listOffer'])]
    #[NotNull]
    private ?Company $provider = null;

    #[ORM\Embedded(class: BeginEndDateEmbeddable::class, columnPrefix: false)]
    #[Groups(['listOffer'])]
    private BeginEndDateEmbeddable $bgedDate;

    public function __construct()
    {
        $this->bgedDate = new BeginEndDateEmbeddable();
    }

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

    public function getProvider(): ?Company
    {
        return $this->provider;
    }

    public function setProvider(?Company $provider): static
    {
        $this->provider = $provider;

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
