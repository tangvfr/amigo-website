<?php

namespace App\Entity\Date;

use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Embeddable]
class BeginEndDateTimeEmbeddable implements IBeginEndDateEmbeddable
{

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['detailEvent'])]
    #[Assert\DateTime]
    private ?DateTimeInterface $beginDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups('detailEvent')]
    #[Assert\DateTime]
    private ?DateTimeInterface $endDate = null;

    public function getBeginDate(): ?DateTimeInterface
    {
        return $this->beginDate;
    }

    public function setBeginDate(?DateTimeInterface $beginDate): static
    {
        $this->beginDate = $beginDate;

        return $this;
    }

    public function getEndDate(): ?DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

}