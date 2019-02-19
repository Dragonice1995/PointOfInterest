<?php
namespace poi_api\Repository;

class CityRepository extends AbstractRepository
{

    public function getCityById($id)
    {
        $repository = $this->entity_manager->getRepository('poi_api\Model\City');
        $city = $repository->findOneBy(array("idCity" => $id));
        return $city;
    }
}