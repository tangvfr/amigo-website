<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Common\Filter\DateFilterInterface;
use ApiPlatform\Doctrine\Common\Filter\SearchFilterInterface;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Entity\Date\AbstractPublishableEntity;
use App\Entity\Date\BeginEndDateTimeEmbeddable;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/',
            normalizationContext: ['groups' => ['minimalEvent']],
        ),
        new GetCollection(
            uriTemplate: '/now',
            normalizationContext: ['groups' => ['minimalEvent']],
            name: Event::NOW_EVENT_API_NAME,
        ),
        new GetCollection(
            uriTemplate: '/past',
            normalizationContext: ['groups' => ['minimalEvent']],
            name: Event::PAST_EVENT_API_NAME,
        ),
        new Get(
            uriTemplate: '/{id}',
            normalizationContext: ['groups' => 'detailEvent']
        ),
    ],
    routePrefix: 'events',
    order: [
        'bgedDate.endDate' => 'desc',
        'bgedDate.beginDate' => 'desc',
        'publicationDate' => 'desc',
    ]
)]
#[ApiFilter(
    BooleanFilter::class,
    properties: ['onlyMiagist', 'cancel']
)]
#[ApiFilter(
    RangeFilter::class,
    properties: ['adhPrice', 'nadhPrice', 'quotaStu']
)]
#[ApiFilter(
    SearchFilter::class,
    properties: [
        'name' => SearchFilterInterface::STRATEGY_IPARTIAL,
        'types.label' => SearchFilterInterface::STRATEGY_IPARTIAL,
        'situated.label' => SearchFilterInterface::STRATEGY_IPARTIAL,
    ]
)]
#[ApiFilter(
    DateFilter::class,
    properties: [
        'bgedDate.beginDate' => DateFilterInterface::INCLUDE_NULL_AFTER,
        'bgedDate.endDate' => DateFilterInterface::INCLUDE_NULL_BEFORE,
    ]
)]
#[ApiFilter(
    OrderFilter::class,
    properties: ['note']
)]
#[ORM\Entity(repositoryClass: EventRepository::class)]
/*
 * Seul la date de fin de l'event est "obligatoire" pour savoir si l'event est fini ou non
 */
class Event extends AbstractPublishableEntity
{
    const PAST_EVENT_API_NAME = 'past';
    const NOW_EVENT_API_NAME = 'now';

    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    #[Groups(['detailEvent', 'minimalEvent'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['detailEvent', 'minimalEvent'])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['detailEvent', 'minimalEvent'])]
    private ?string $img = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Groups('detailEvent')]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\NotNull]
    #[Groups('detailEvent')]
    private ?bool $onlyMiagist = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    #[Assert\PositiveOrZero]
    #[Groups('detailEvent')]
    private ?string $nadhPrice = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    #[Assert\PositiveOrZero]
    #[Groups('detailEvent')]
    private ?string $adhPrice = null;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero]
    #[Groups('detailEvent')]
    private ?int $quotaStu = null;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero]
    private ?int $quotaComp = null;

    #[ORM\Column]
    #[Assert\NotNull, Assert\Range(min: 0, max: 5)]
    private ?int $note = null;

    #[ORM\Column]
    #[Assert\NotNull]
    #[Groups(['detailEvent', 'minimalEvent'])]
    private ?bool $cancel = null;

    #[ORM\ManyToMany(targetEntity: EventType::class)]
    #[Groups('detailEvent')]
    private Collection $types;

    #[ORM\ManyToMany(targetEntity: Location::class)]
    #[Groups('detailEvent')]
    private Collection $situated;

    #[ORM\Embedded(class: BeginEndDateTimeEmbeddable::class, columnPrefix: false)]
    #[Groups(['detailEvent'])]
    private BeginEndDateTimeEmbeddable $bgedDate;

    public function __construct()
    {
        $this->types = new ArrayCollection();
        $this->situated = new ArrayCollection();
        $this->bgedDate = new BeginEndDateTimeEmbeddable();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): static
    {
        $this->img = $img;

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

    public function isOnlyMiagist(): ?bool
    {
        return $this->onlyMiagist;
    }

    public function setOnlyMiagist(bool $onlyMiagist): static
    {
        $this->onlyMiagist = $onlyMiagist;

        return $this;
    }

    public function getNadhPrice(): ?string
    {
        return $this->nadhPrice;
    }

    public function setNadhPrice(?string $nadhPrice): static
    {
        $this->nadhPrice = $nadhPrice;

        return $this;
    }

    public function getAdhPrice(): ?string
    {
        return $this->adhPrice;
    }

    public function setAdhPrice(string $adhPrice): static
    {
        $this->adhPrice = $adhPrice;

        return $this;
    }

    public function getQuotaStu(): ?int
    {
        return $this->quotaStu;
    }

    public function setQuotaStu(?int $quotaStu): static
    {
        $this->quotaStu = $quotaStu;

        return $this;
    }

    public function getQuotaComp(): ?int
    {
        return $this->quotaComp;
    }

    public function setQuotaComp(?int $quotaComp): static
    {
        $this->quotaComp = $quotaComp;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function isCancel(): ?bool
    {
        return $this->cancel;
    }

    public function setCancel(bool $cancel): static
    {
        $this->cancel = $cancel;

        return $this;
    }

    /**
     * @return Collection<int, EventType>
     */
    public function getTypes(): Collection
    {
        return $this->types;
    }

    public function addType(EventType $type): static
    {
        if (!$this->types->contains($type)) {
            $this->types->add($type);
        }

        return $this;
    }

    public function removeType(EventType $type): static
    {
        $this->types->removeElement($type);

        return $this;
    }

    /**
     * @return Collection<int, Location>
     */
    public function getSituated(): Collection
    {
        return $this->situated;
    }

    public function addSituated(Location $situated): static
    {
        if (!$this->situated->contains($situated)) {
            $this->situated->add($situated);
        }

        return $this;
    }

    public function removeSituated(Location $situated): static
    {
        $this->situated->removeElement($situated);

        return $this;
    }

    public function getBgedDate(): BeginEndDateTimeEmbeddable
    {
        return $this->bgedDate;
    }

    public function setBgedDate(BeginEndDateTimeEmbeddable $bgedDate): static
    {
        $this->bgedDate = $bgedDate;

        return $this;
    }

}
