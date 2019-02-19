<?php

use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use poi_api\Controller\PoiController;
use poi_api\Repository\PoiRepository;
use poi_api\Service\PoiService;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\SerializerServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Symfony\Component\HttpFoundation\Request;

$app->register(new SerializerServiceProvider());

$app->register(new DoctrineServiceProvider, [
    'db.options' => [
        'dbname' => 'poi_schema',
        'user' => 'root',
        'password' => 'root',
        'host' => '192.168.51.51',
        'driver' => 'pdo_mysql'
    ]
]);

$app->register(new DoctrineOrmServiceProvider, array(
    'orm.proxies_dir' => __DIR__.'/proxies',
    'orm.em.options' => array(
        'mappings' => array(
            array(
                'type' => 'annotation',
                'use_simple_annotation_reader' => false,
                'namespace' => 'poi_api\Model',
                'path' => __DIR__.'/Model',
            ),
        ),
    ),
));

$app->register(new ServiceControllerServiceProvider());

$app->before(function(Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});


// services
$app['poi.controller'] = function ($app) {
    return new PoiController($app['poi.service'], $app['serializer']);
};
$app['poi.service'] = function ($app) {
    return new PoiService($app['poi.repository']);
};
$app['poi.repository'] = function ($app) {
    return new PoiRepository($app['orm.em']);
};


// routes
$route = $app['controllers_factory'];
$route->post('/poi', 'poi.controller:createPoint');
$route->put('/poi/{id}', 'poi.controller:updatePoint');
$route->get('/poi', 'poi.controller:getClosestPoints');
$route->get('/poi/city', 'poi.controller:getAllCityPoints');
$app->mount('/', $route);