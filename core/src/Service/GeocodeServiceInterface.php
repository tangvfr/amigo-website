<?php

namespace App\Service;

use App\Entity\Location;
use App\Model\Addresse;
use App\Model\Coord;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

interface GeocodeServiceInterface
{
    const HTTP_TOO_MANY_REQUESTS = Response::HTTP_TOO_MANY_REQUESTS;
    const HTTP_UNAUTHORIZED = Response::HTTP_UNAUTHORIZED;
    const HTTP_INTERNAL_SERVER_ERROR = Response::HTTP_INTERNAL_SERVER_ERROR;

    /**
     * @return string | Coord[] | int
     */
    public function geocodeLoc(Location $loc, bool $toCoord = false): string | array | int;

    /**
     * @return string | Coord[] | int
     */
    public function geocodeAddr(Addresse $addr, bool $toCoord = false): string | array | int;

    /**
     * @return string | Coord[] | int
     */
    public function geocodeQuery(string $query, bool $toCoord = false): string | array | int;

}