<?php
// Setup Doctrine
$configuration = Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
    $paths = [__DIR__ . '/Model'],
    $isDevMode = true,
    null, null, false
);

// Setup connection parameters
$connection_parameters = [
    'dbname' => 'poi_schema',
    'user' => 'root',
    'password' => 'root',
    'host' => '192.168.51.51',
    'driver' => 'pdo_mysql'
];

// Get the entity manager
$entity_manager = Doctrine\ORM\EntityManager::create($connection_parameters, $configuration);