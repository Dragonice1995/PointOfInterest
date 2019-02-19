<?php
namespace poi_api\Service;

use poi_api\Model\Geoplugin;
use poi_api\Model\Poi;
use poi_api\Repository\PoiRepository;

class PoiService
{
    protected $poiRepository;
    protected $geoplugin;

    public function __construct(PoiRepository $poiRepository)
    {
        $this->poiRepository = $poiRepository;
        $this->geoplugin = new Geoplugin();
    }

    public function createPoint($poiData)
    {
        $city = $this->poiRepository->getCityById($poiData["idCity"]);
        $newPoint = (new Poi())
            ->setName($poiData["name"])
            ->setDescription($poiData["description"])
            ->setType($poiData["type"])
            ->setLatitude($poiData["latitude"])
            ->setLongitude($poiData["longitude"])
            ->setIdCity($city);

        $newPoint = $this->poiRepository->savePoint($newPoint);

        return $newPoint;
    }

    public function updatePoint($id, $poiData)
    {
        $point = $this->poiRepository->getPointById($id);

        if ($poiData["name"] !== null) {
            $point = $point->setName($poiData["name"]);
        }
        if ($poiData["description"] !== null) {
            $point = $point->setDescription($poiData["description"]);
        }
        if ($poiData["type"] !== null) {
            $point = $point->setType($poiData["type"]);
        }
        if ($poiData["latitude"] !== null) {
            $point = $point->setLatitude($poiData["latitude"]);
        }
        if ($poiData["longitude"] !== null) {
            $point = $point->setLongitude($poiData["longitude"]);
        }
        if ($poiData["idCity"] !== null) {
            $city = $this->poiRepository->getCityById($poiData["idCity"]);
            $point = $point->setIdCity($city);
        }

        $point = $this->poiRepository->savePoint($point);

        return $point;
    }

    public function getClosestPoints($ip, $radius)
    {
        $this->geoplugin->locate($ip);
        $allPoint = $this->poiRepository->getClosestPoints($this->geoplugin->getLatitude(), $this->geoplugin->getLongitude(), $radius);

        return $allPoint;
    }

    public function getAllCityPoints($city, $limit, $offset)
    {
        return $this->poiRepository->getAllCityPoints($city, $limit, $offset);
    }

    public function getCityByIp($ip)
    {
        $this->geoplugin->locate($ip);
        return $this->geoplugin->getCity();
    }
}