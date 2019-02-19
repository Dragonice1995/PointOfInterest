<?php
namespace poi_api\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use poi_api\Model\Poi;
use Symfony\Component\HttpFoundation\Response;


class PoiController extends AbstractController
{
    public function createPoint(Request $request)
    {
        // TODO: исключительные ситуации

        $dataPoi = array(
            "name" => $request->get('name'),
            "description" => $request->get('description'),
            "type" => $request->get('type'),
            "latitude" => $request->get('latitude'),
            "longitude" => $request->get('longitude')
        );

        $newPoi = $this->poiService->createPoint($dataPoi);

        return new JsonResponse(
            [
                'point' => $newPoi->getIdPoi()
            ],
            Response::HTTP_CREATED
        );
    }

    public function getClosestPoints(Request $request)
    {
        // TODO: исключительные ситуации

        $ip = $request->query->get('ip');
        if ($ip === null) {
            $ip = $request->getClientIp();
        };
        $radius = $request->query->get('radius');
        if ($radius === null) {
            $radius = 1;
        }
        $closestPoints = $this->poiService->getClosestPoints(
            $ip,
            $radius
        );

        $response = new Response($this->objectsToJson($closestPoints));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function getAllCityPoints(Request $request)
    {
        // TODO: по умолчанию значения
        $city = $request->query->get("city");
        $limit = $request->query->get("limit");
        $offset = $request->query->get("offset");
        $cityPoints = $this->poiService->getAllCityPoints($city, $limit, $offset);
        $response = new Response($this->objectsToJson($cityPoints));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}