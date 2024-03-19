<?php

namespace App\Model;

use App\Entity\Location;

class Addresse
{

    const EMPTY_END = '';
    const COMMA_END = ',';
    const SEPARATOR_QUERY = ' ';

    public function __construct(
        public ?string $adresse = null,
        public ?string $postalCode = null,
        public ?string $city = null,
        public ?string $country = null,
    ){}

    public function toQuery(): string
    {
        $str = '';

        $str = self::appendIfNotNull($str, $this->adresse, self::COMMA_END);
        $str = self::appendIfNotNull($str, $this->postalCode);
        $str = self::appendIfNotNull($str, $this->city);
        $str = self::appendIfNotNull($str, $this->country);

        return $str;
    }

    private static function appendIfNotNull(string $str, ?string $appened, string $end = self::EMPTY_END): string
    {
        return $appened !== null ? $str.self::SEPARATOR_QUERY.$appened.$end : $str;
    }

    public static function createFromLocation(Location $location): Addresse
    {
        return new Addresse(
            adresse: $location->getAdresse(),
            postalCode: $location->getPostalCode(),
            city: $location->getCity(),
            country: $location->getCountry(),
        );
    }

}