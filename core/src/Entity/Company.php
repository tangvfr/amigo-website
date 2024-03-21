<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[Get(
    normalizationContext: ['groups' => 'infoCompany']
)]
#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[UniqueEntity(fields: 'name')]
class Company
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    #[Groups(['challengerCompany', 'discountCompany', 'listOffer', 'infoCompany'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank]
    #[Groups(['challengerCompany', 'discountCompany', 'listOffer', 'infoCompany'])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['challengerCompany', 'discountCompany', 'listOffer', 'infoCompany'])]
    private ?string $img = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('discountCompany')]
    private ?string $banner = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Groups(['challengerCompany', 'discountCompany', 'infoCompany'])]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Location::class)]
    #[Groups(['challengerCompany', 'discountCompany', 'infoCompany'])]
    private Collection $located;

    #[ORM\ManyToMany(targetEntity: CompanyType::class)]
    #[Groups(['challengerCompany', 'discountCompany', 'infoCompany'])]
    private Collection $activities;

    public function __construct()
    {
        $this->located = new ArrayCollection();
        $this->activities = new ArrayCollection();
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

    public function getBanner(): ?string
    {
        return $this->banner;
    }

    public function setBanner(?string $banner): static
    {
        $this->banner = $banner;

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

    /**
     * @return Collection<int, Location>
     */
    public function getLocated(): Collection
    {
        return $this->located;
    }

    public function addLocated(Location $located): static
    {
        if (!$this->located->contains($located)) {
            $this->located->add($located);
        }

        return $this;
    }

    public function removeLocated(Location $located): static
    {
        $this->located->removeElement($located);

        return $this;
    }

    /**
     * @return Collection<int, CompanyType>
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    public function addActivity(CompanyType $activity): static
    {
        if (!$this->activities->contains($activity)) {
            $this->activities->add($activity);
        }

        return $this;
    }

    public function removeActivity(CompanyType $activity): static
    {
        $this->activities->removeElement($activity);

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
