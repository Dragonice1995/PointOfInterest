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
        $dataPoi = array(
            "name" => $request->get('name'),
            "description" => $request->get('description'),
            "type" => $request->get('type'),
            "latitude" => $request->get('latitude'),
            "longitude" => $request->get('longitude'),
            "idCity" => $request->get('idCity')
        );
        if (in_array(null, $dataPoi)) {
            return $this->createErrorResponse("Не все значения переданы для создания!");
        }

        try {
            $newPoi = $this->poiService->createPoint($dataPoi);
        } catch (\Exception $e) {
            return $this->createErrorResponse($e->getMessage());
        }

        return new JsonResponse(
            [
                'point' => $newPoi->getIdPoi()
            ],
            Response::HTTP_CREATED
        );
    }

    public function updatePoint(Request $request)
    {
        $id = $request->get('id');

        $dataPoi = array(
            "name" => $request->get('name'),
            "description" => $request->get('description'),
            "type" => $request->get('type'),
            "latitude" => $request->get('latitude'),
            "longitude" => $request->get('longitude'),
            "idCity" => $request->get('idCity')
        );
        
        try {
            $newPoi = $this->poiService->updatePoint($id, $dataPoi);
        } catch (\Exception $e) {
            return $this->createErrorResponse($e->getMessage());
        }

        $response = new Response($this->objectsToJson($newPoi));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function getClosestPoints(Request $request)
    {
        $ip = $request->query->get('ip');
        if ($ip === null) {
            $ip = $request->getClientIp();
        };
        $radius = $request->query->get('radius');
        if ($radius === null) {
            $radius = 1;
        }

        try {
            $closestPoints = $this->poiService->getClosestPoints(
                $ip,
                $radius
            );
        } catch (\Exception $e) {
            return $this->createErrorResponse($e->getMessage());
        }

        $response = new Response($this->objectsToJson($closestPoints));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function getAllCityPoints(Request $request)
    {
        $city = $request->query->get("city");
        if ($city === null) {
            $city = $this->poiService->getCityByIp($request->getClientIp());
        }
        $limit = $request->query->get("limit");
        if ($limit === null) {
            $limit = 50;
        }
        $offset = $request->query->get("offset");
        if ($offset === null) {
            $offset = 0;
        }

        try {
            $cityPoints = $this->poiService->getAllCityPoints($city, $limit, $offset);
        } catch (\Exception $e) {
            return $this->createErrorResponse($e->getMessage());
        }

        $response = new Response($this->objectsToJson($cityPoints));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}