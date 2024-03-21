<?php

namespace App\Controller\Api;

use App\Service\GeocodeServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

class GeocodeApiController extends AbstractController
{

    public function __construct(
        private readonly GeocodeServiceInterface $geocodeService
    ){}

    #[Route('/geocode/api', name: 'app_geocode_api')]
    public function index(
        #[MapQueryParameter] ?string $query = null,
        #[MapQueryParameter(filter: FILTER_VALIDATE_BOOLEAN)] bool $detail = false,
    ): JsonResponse
    {
        if ($query === null) {
            return new JsonResponse(['errorCode' => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
        }

        //$respCode;
        //$respContent
        $coord = $this->geocodeService->geocodeQuery($query, !$detail);

        if (is_array($coord) || is_string($coord)) {
            $respCode = Response::HTTP_OK;
            $respContent = $coord;
        } else {
            $respCode = $coord;
            $respContent = ['errorCode' => $coord];
        }

        return new JsonResponse($respContent, $respCode, [], $detail);
    }

}
