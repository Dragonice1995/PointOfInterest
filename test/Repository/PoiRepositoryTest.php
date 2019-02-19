<?php
namespace poi_api\Repository;

use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use poi_api\Model\City;
use poi_api\Model\Poi;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Tools\SchemaTool;

class PoiRepositoryTest extends TestCase
{
    protected $rep;
    protected $em;

    protected function setUp() : void
    {
        $configuration = Setup::createAnnotationMetadataConfiguration(
            $paths = [__DIR__.'/../../src/Model'],
            $isDevMode = true,
            null, null, false
        );

        $connection_parameters = array(
            'url' => 'sqlite:///:memory:',
        );

        $entity_manager = EntityManager::create($connection_parameters, $configuration);
        $schema_tool = new SchemaTool($entity_manager);
        $metadata_factory = $entity_manager->getMetadataFactory();
        $classes = $metadata_factory->getAllMetadata();
        $schema_tool->dropDatabase();
        $schema_tool->createSchema($classes);

        $this->em = $entity_manager;
        for ($i = 1; $i <= 2; $i++) {
            $poi = new Poi();
            $poi->setIdPoi($i)
                ->setName("test")
                ->setDescription("test")
                ->setType("test")
                ->setLongitude($i)
                ->setLatitude($i);
            $this->em->persist($poi);
        }
        $this->em->flush();

        $this->rep = new PoiRepository($entity_manager);
    }

    /**
     * @after
     */
    protected function clearDatabaseAndAdd()
    {
        $this->em->clear();

        for ($i = 1; $i <= 2; $i++) {
            $poi = new Poi();
            $poi->setIdPoi($i)
                ->setName("test")
                ->setDescription("test")
                ->setType("test")
                ->setLongitude($i)
                ->setLatitude($i);
            $this->em->persist($poi);
        }
        $this->em->flush();
    }

    public function testGetPointById()
    {
        $poi = new Poi();
        $poi->setIdPoi(1)
            ->setName("test")
            ->setDescription("test")
            ->setType("test")
            ->setLongitude(1)
            ->setLatitude(1);
        $this->assertEquals($poi, $this->rep->getPointById(1));
        $this->assertEquals(null, $this->rep->getPointById(3));
    }

    public function testGetAllCityPoints()
    {
        $city = (new City())->setIdCity(1)->setName('Perm');
        $this->em->persist($city);
        $this->em->flush();

        $poi = new Poi();
        $poi->setIdPoi(3)
            ->setName("test")
            ->setDescription("test")
            ->setType("test")
            ->setLongitude(1)
            ->setLatitude(1)
            ->setIdCity($city);
        $this->rep->savePoint($poi);
        $this->assertEquals(array($poi), $this->rep->getAllCityPoints('Perm', 50, 0));
    }

    public function testSavePoint()
    {
        $poi = new Poi();
        $poi->setIdPoi(3)
            ->setName("test")
            ->setDescription("test")
            ->setType("test")
            ->setLongitude("1")
            ->setLatitude("1");
        $this->rep->savePoint($poi);
        $this->assertEquals($poi, $this->rep->getPointById($poi->getIdPoi()));
    }

    public function testFindPoints()
    {
        $points = array();
        $poi1 = new Poi();
        $poi1->setIdPoi(1)
            ->setName("test1")
            ->setDescription("test1")
            ->setType("test1")
            ->setLongitude(58.01)
            ->setLatitude(56.2273);
        array_push($points, $poi1);
        $poi2 = new Poi();
        $poi2->setIdPoi(2)
            ->setName("test2")
            ->setDescription("test2")
            ->setType("test2")
            ->setLongitude(61.9601)
            ->setLatitude(129.596);
        array_push($points, $poi2);
        $this->assertEquals(array($poi1), $this->rep->findPoints(56.25, 58, 100, $points));
    }
}
