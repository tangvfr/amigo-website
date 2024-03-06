<?php

namespace App\Entity\Date;

use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Embeddable]
class BeginEndDateEmbeddable implements IBeginEndDateEmbeddable
{

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['challengerCompany', 'discountCompany', 'listOffer'])]
    private ?DateTimeInterface $beginDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['discountCompany', 'listOffer'])]
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