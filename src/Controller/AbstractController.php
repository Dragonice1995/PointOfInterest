<?php
namespace poi_api\Controller;

use poi_api\Service\PoiService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;

abstract class AbstractController
{
    protected $poiService;
    protected $serializer;

    public function __construct(PoiService $poiService, Serializer $serializer)
    {
        $this->poiService = $poiService;
        $this->serializer = $serializer;
    }

    protected function createErrorResponse($message)
    {
        return new JsonResponse(
            ['error' => $message],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    protected function createNotFoundResponse()
    {
        return new JsonResponse(
            ['error' => 'Resource not found!'],
          Response::HTTP_NOT_FOUND
        );
    }

    protected function objectsToJson($object)
    {
        return $this->serializer->serialize($object, 'json');
    }
}