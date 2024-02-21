<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $onlyMiagist = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $nadhPrice = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $adhPrice = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $beginDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(nullable: true)]
    private ?int $quotaStu = null;

    #[ORM\Column(nullable: true)]
    private ?int $quotaComp = null;

    #[ORM\Column]
    private ?int $note = null;

    #[ORM\Column]
    private ?bool $cancel = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $publicationDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $creationDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lastEditDate = null;

    #[ORM\ManyToMany(targetEntity: EventType::class)]
    private Collection $types;

    #[ORM\ManyToMany(targetEntity: Location::class)]
    private Collection $situated;

    public function __construct()
    {
        $this->types = new ArrayCollection();
        $this->situated = new ArrayCollection();
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

    public function getBeginDate(): ?\DateTimeInterface
    {
        return $this->beginDate;
    }

    public function setBeginDate(?\DateTimeInterface $beginDate): static
    {
        $this->beginDate = $beginDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

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

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(?\DateTimeInterface $publicationDate): static
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): static
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getLastEditDate(): ?\DateTimeInterface
    {
        return $this->lastEditDate;
    }

    public function setLastEditDate(?\DateTimeInterface $lastEditDate): static
    {
        $this->lastEditDate = $lastEditDate;

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
}
