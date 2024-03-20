<?php

namespace App\Entity\Date;

use DateTimeInterface;

interface IBeginEndDateEmbeddable
{
    public function getBeginDate(): ?DateTimeInterface;

    public function setBeginDate(?DateTimeInterface $beginDate): static;

    public function getEndDate(): ?DateTimeInterface;

    public function setEndDate(?DateTimeInterface $endDate): static;

}