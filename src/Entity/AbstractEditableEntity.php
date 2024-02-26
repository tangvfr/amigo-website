<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
class AbstractEditableEntity
{

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?DateTimeInterface $creationDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $lastEditDate = null;

    public function getCreationDate(): ?DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(DateTimeInterface $creationDate): static
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getLastEditDate(): ?DateTimeInterface
    {
        return $this->lastEditDate;
    }

    public function setLastEditDate(?DateTimeInterface $lastEditDate): static
    {
        $this->lastEditDate = $lastEditDate;

        return $this;
    }

}