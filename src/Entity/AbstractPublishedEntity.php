<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
class AbstractPublishedEntity extends AbstractBeginEndDateEntity
{

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $publicationDate = null;

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