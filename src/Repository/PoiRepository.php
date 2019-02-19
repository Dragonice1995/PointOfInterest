<?php
namespace poi_api\Repository;

use poi_api\Model\Poi;

class PoiRepository extends AbstractRepository
{
    public function getClosestPoints($lat, $long, $radius)
    {
        $repository = $this->entity_manager->getRepository('poi_api\Model\Poi');
        $points = $repository->findAll();
        $findPoints = array();
        foreach ($points as $point) {
            $lat2 = $point->getLatitude();
            $long2 = $point->getLongitude();
            $distance = rad2deg(acos((sin(deg2rad($lat))*sin(deg2rad($lat2))) + (cos(deg2rad($lat))*cos(deg2rad($lat2))*cos(deg2rad($long-$long2))))) * 111.13384;
            if ($distance <= $radius) {
                array_push($findPoints, $point);
            }
        }

        return $findPoints;
    }

    public function getAllCityPoints($city, $limit, $offset)
    {
        //TODO: 404 если нет города
        $cityRepository = $this->entity_manager->getRepository('poi_api\Model\City');
        $idCity = $cityRepository->findOneBy(array("name" => $city))->getIdCity();
        $poiRepository = $this->entity_manager->getRepository('poi_api\Model\Poi');
        $points = $poiRepository->findBy(array("idCity" => $idCity), array("idPoi" => "asc"), $limit, $offset);

        return $points;
    }

    public function savePoint(Poi $poi)
    {
        if ($poi->getIdPoi() !== null) {
            $this->entity_manager->persist($poi);
            $this->entity_manager->flush();
        } else {
            $this->entity_manager->persist($poi);
            $this->entity_manager->flush();
        }

        return $poi;
    }

    public function getPointById($id)
    {
        $repository = $this->entity_manager->getRepository('poi_api\Model\Poi');
        $point = $repository->findOneBy(array("idPoi" => $id));
        return $point;
    }

    public function getCityById($id)
    {
        $repository = $this->entity_manager->getRepository('poi_api\Model\City');
        $city = $repository->findOneBy(array("idCity" => $id));
        return $city;
    }
}