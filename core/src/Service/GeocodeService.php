<?php

namespace App\Service;

use App\Entity\Location;
use App\Model\Address;
use App\Model\Coord;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GeocodeService implements GeocodeServiceInterface
{

    const GET_METHOD = 'GET';
    const GEOCODE_MAP_URL = 'https://geocode.maps.co/search';
    const API_KEY_PARAM = 'api_key';
    const QUERY_PARAM = 'q';

    public function __construct(
        private readonly HttpClientInterface                              $httpClient,
        #[Autowire('%env(APP_GEOCODE_API_KEY)%')] private readonly string $geocodeApiKey,
    ){}

    /**
     * @return string | Coord[] | int
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function geocodeLoc(Location $loc, bool $toCoord = false): string | array | int
    {
        return $this->geocodeAddr(Address::createFromLocation($loc, $toCoord));
    }


    /**
     * @return string | Coord[] | int
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function geocodeAddr(Address $addr, bool $toCoord = false): string | array | int
    {
        return $this->geocodeQuery($addr->toQuery(), $toCoord);
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
        } catch (TransportExceptionInterface $e) {
            $result = self::HTTP_GATEWAY_TIMEOUT;
        }

        return $result;
    }

}