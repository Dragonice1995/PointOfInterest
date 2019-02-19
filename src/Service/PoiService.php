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
        $newPoint = (new Poi())
            ->setName($poiData["name"])
            ->setDescription($poiData["description"])
            ->setType($poiData["type"])
            ->setLatitude($poiData["latitude"])
            ->setLongitude($poiData["longitude"]);

        $newPoint = $this->poiRepository->savePoint($newPoint);

        return $newPoint;
    }

    public function updatePoint($poiData)
    {

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
}