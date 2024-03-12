<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $banner = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Location::class)]
    private Collection $located;

    #[ORM\ManyToMany(targetEntity: CompanyType::class)]
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
}
