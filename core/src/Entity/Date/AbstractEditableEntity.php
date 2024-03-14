<?php

namespace App\Entity\Date;

use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Monolog\DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\MappedSuperclass, Orm\HasLifecycleCallbacks]
class AbstractEditableEntity
{

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Assert\DateTime]
    private ?DateTimeInterface $creationDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Assert\DateTime]
    private ?DateTimeInterface $lastEditDate = null;

    public function getCreationDate(): ?DateTimeInterface
    {
        return $this->creationDate;
    }

    #[ORM\PrePersist]
    public function setCreationDate(): static
    {
        $this->creationDate = new DateTimeImmutable('now');
        return $this;
    }

    public function isEdited(): bool
    {
        return $this->lastEditDate !== null;
    }

    public function getLastEditDate(): ?DateTimeInterface
    {
        return $this->lastEditDate;
    }

    #[ORM\PreUpdate]
    public function setLastEditDate(): static
    {
        $this->lastEditDate = new DateTimeImmutable('now');
        return $this;
    }

}