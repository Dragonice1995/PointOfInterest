<?php
namespace poi_api\Repository;

use Doctrine\ORM\EntityManager;

abstract class AbstractRepository
{
    protected $entity_manager;

    public function __construct(EntityManager $entity_manager)
    {
        $this->entity_manager = $entity_manager;
    }
}