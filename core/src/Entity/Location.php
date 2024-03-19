<?php

namespace App\Entity;

use ApiPlatform\Metadata\Tests\Fixtures\Metadata\Get;
use App\Repository\LocationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[Get]
#[ORM\Entity(repositoryClass: LocationRepository::class)]
#[Groups(['detailEvent', 'challengerCompany', 'discountCompany', 'infoCompany'])]
class Location
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    #[Assert\NotNull]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank]
    private ?string $label = null;

    #[ORM\Column]
    #[Assert\NotNull]
    private ?float $latitude = null;

    #[ORM\Column]
    #[Assert\NotNull]
    private ?float $longitude = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(allowNull: true)]
    private ?string $country = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(allowNull: true)]
    private ?string $city = null;

    #[ORM\Column(length: 6, nullable: true)]
    #[Assert\NotBlank(allowNull: true)]
    private ?string $postalCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(allowNull: true)]
    private ?string $adresse = null;

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

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function __toString()
    {
        return $this->label;
    }
}
