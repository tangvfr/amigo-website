<?php

namespace App\Model;

class Coord
{
    public function __construct(
        public float $latitude,
        public float $longitude,
    ) {}
}