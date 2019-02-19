<?php
namespace poi_api\Service;

use PHPUnit\Framework\TestCase;
use poi_api\Model\City;
use poi_api\Model\Geoplugin;
use poi_api\Model\Poi;
use poi_api\Repository\CityRepository;
use poi_api\Repository\PoiRepository;

class PoiServiceTest extends TestCase
{
    protected $service;

    public function getPoints()
    {
        return array(
            (new Poi())->setIdPoi(1)
                ->setName("test")
                ->setDescription("test")
                ->setType("test")
                ->setLongitude(1)
                ->setLatitude(1),
            (new Poi())->setIdPoi(2)
                ->setName("test2")
                ->setDescription("test2")
                ->setType("test2")
                ->setLongitude(2)
                ->setLatitude(2)
        );
    }

    public function getCity()
    {
        return array(
            (new City())->setIdCity(1)
                ->setName("test"),
            (new City())->setIdCity(2)
                ->setName("test2")
        );
    }

    protected function setUp() : void
    {
        $points = $this->getPoints();

        $poiRep = $this->createMock(PoiRepository::class);
        $poiRep->expects($this->any())
            ->method('savePoint')
            ->will($this->returnValue($points[0]));
        $poiRep->expects($this->any())
            ->method('getPointById')
            ->will($this->returnValue($points[0]));
        $poiRep->expects($this->any())
            ->method('getClosestPoints')
            ->will($this->returnValue($points));
        $poiRep->expects($this->any())
            ->method('getAllCityPoints')
            ->will($this->returnValue($points));

        $citys = $this->getCity();
        $cityRep = $this->createMock(CityRepository::class);
        $cityRep->expects($this->any())
            ->method('getCityById')
            ->will($this->returnValue($citys[0]));

        $geo = new Geoplugin();
        $geo->setCity('Perm');
        $geo->setIp('10.10.10.10');
        $geo->setLatitude(1);
        $geo->setLongitude(1);
        $geoRep = $this->createMock(Geoplugin::class);
        $geoRep->expects($this->any())
            ->method('locate')
            ->will($this->returnValue($geo));

        $this->service = new PoiService($poiRep, $cityRep, $geoRep);
    }

    public function testGetClosestPoints()
    {
        $this->assertEquals($this->getPoints(), $this->service->getClosestPoints('10.10.10.10', 1));
    }

    public function testGetCityByIp()
    {
        $this->assertEquals('Perm', $this->service->getCityByIp('10.10.10.10'));
    }

}
