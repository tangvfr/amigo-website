<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
class AbstractPublishedEntity extends AbstractBeginEndDateEntity
{

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?DateTimeInterface $creationDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $lastEditDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $publicationDate = null;

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

    public function getPublicationDate(): ?DateTimeInterface
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(?DateTimeInterface $publicationDate): static
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

}