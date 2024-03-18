<?php

namespace App\Entity;

use ApiPlatform\Metadata\Tests\Fixtures\Metadata\Get;
use App\Repository\EventTypeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[Get(normalizationContext: ['groups' => 'detailEventType'])]
#[ORM\Entity(repositoryClass: EventTypeRepository::class)]
class EventType
{
    #[ORMId, ORMGeneratedValue, ORMColumn]
    #[Groups(['detailEventType', 'detailEvent'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank]
    #[Groups(['detailEventType', 'detailEvent'])]
    private ?string $label = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Groups('detailEventType')]
    private ?string $description = null;

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
}
