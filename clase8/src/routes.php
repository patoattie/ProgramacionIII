<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\cd;
use App\Models\cdApi;



return function (App $app) {
    $container = $app->getContainer();

    // Rutas PDO
    $routes = require __DIR__ . '/../src/routes/routesPDO.php';
    $routes($app);
    

    // Rutas ORM
    $routes = require __DIR__ . '/../src/routes/routesORM.php';
    $routes($app);

    // Rutas JWT
    $routes = require __DIR__ . '/../src/routes/routesJWT.php';
    $routes($app);


    /*$app->get('/[{name}]', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");
        // $container->get('logger')->addCritical('Hey, a critical log entry!');
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });*/

    $app->get('[/]', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");
        // $container->get('logger')->addCritical('Hey, a critical log entry!');
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });

    //agrego a mano (GET)
    $app->get('/error[/]', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('errorlogger')->info("Slim-Skeleton '/' route");
        // $container->get('logger')->addCritical('Hey, a critical log entry!');
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });

    //agrego a mano (POST)
    $app->post('/error[/]', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('errorlogger')->info("Slim-Skeleton '/' route");
        // $container->get('logger')->addCritical('Hey, a critical log entry!');
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });

    //agrego a mano (PUT)
    $app->put('/error[/]', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('errorlogger')->info("Slim-Skeleton '/' route");
        // $container->get('logger')->addCritical('Hey, a critical log entry!');
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });

    //agrego a mano (DELETE)
    $app->delete('/error[/]', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('errorlogger')->info("Slim-Skeleton '/' route");
        // $container->get('logger')->addCritical('Hey, a critical log entry!');
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });

};
