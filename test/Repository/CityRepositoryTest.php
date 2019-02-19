<?php
namespace poi_api\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;
use PHPUnit\Framework\TestCase;
use poi_api\Model\City;

class CityRepositoryTest extends TestCase
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
            $city = new City();
            $city->setIdCity($i)
                ->setName("test");
            $this->em->persist($city);
        }
        $this->em->flush();

        $this->rep = new CityRepository($entity_manager);
    }

    public function testGetCityById()
    {
        $this->assertEquals(1, $this->rep->getCityById(1)->getIdCity());
        $this->assertEquals(2, $this->rep->getCityById(2)->getIdCity());
    }
}
