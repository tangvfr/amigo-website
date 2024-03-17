<?php

namespace App\Entity\Date;

use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\MappedSuperclass]
class AbstractPublishableEntity extends AbstractEditableEntity
{

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups('detailEvent')]
    #[Assert\DateTime]
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