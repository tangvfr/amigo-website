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

class GeocodeService
{

    const GET_METHOD = 'GET';
    const GEOCODE_MAP_URL = 'https://geocode.maps.co/search';
    const API_KEY_PARAM = 'api_key';
    const QUERY_PARAM = 'q';
    const HTTP_TOO_MANY_REQUESTS = Response::HTTP_TOO_MANY_REQUESTS;
    const HTTP_UNAUTHORIZED = Response::HTTP_UNAUTHORIZED;
    const HTTP_INTERNAL_SERVER_ERROR = Response::HTTP_INTERNAL_SERVER_ERROR;

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        #[Autowire('%env(APP_GEOCODE_API_KEY)%')] private string $geocodeApiKey,
    ){}

    public function geocodeLoc(Location $loc): Coord
    {
        return $this->geocodeAddr(Addresse::createFromLocation($loc));
    }

    public function geocodeAddr(Addresse $addr): Coord
    {
        return $this->geocodeQuery($addr->toQuery());
    }

    /**
     * @return string | Coord[] | int
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function geocodeQuery(string $query, bool $toCoord = false): string | array | int
    {
        $result = self::HTTP_INTERNAL_SERVER_ERROR;
        try {
            $resp = $this->httpClient->request(
                self::GET_METHOD,
                self::GEOCODE_MAP_URL,
                ['query' => [
                    self::API_KEY_PARAM => $this->geocodeApiKey,
                    self::QUERY_PARAM => $query,
                ]]
            );

            $code = $resp->getStatusCode();
            switch ($code) {
                case Response::HTTP_OK:
                    if ($toCoord) {
                        $result = [];
                        foreach ($resp->toArray(false) as $coord) {
                            $result[] = new Coord($coord['lat'], $coord['lon']);
                        }
                    } else {
                        $result = $resp->getContent(false);
                    }
                    break;

                case self::HTTP_UNAUTHORIZED:
                case self::HTTP_TOO_MANY_REQUESTS:
                    $result = $code;
                    break;

                default:
                    break;
            }
        } catch (TransportExceptionInterface $e) {}

        return $result;
    }

}