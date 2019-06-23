<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\cd;
//use App\Models\ORM\cdApi; //Daba error RuntimeException: Callable App\Models\ORM\cdApi does not exist in /opt/lampp/htdocs/ProgramacionIII/clase8/vendor/slim/slim/Slim/CallableResolver.php:90 Stack trace: #0 LO REEMPLAZO POR:
use App\Models\ORM\cdControler;


include_once __DIR__ . '/../../src/app/modelORM/cd.php';
include_once __DIR__ . '/../../src/app/modelORM/cdControler.php';

return function (App $app) {
    $container = $app->getContainer();

     $app->group('/cdORM', function () {   
         
        $this->get('[/]', function ($request, $response, $args) {
          //return cd::all()->toJson();
          $todosLosCds=cd::all();
          $newResponse = $response->withJson($todosLosCds, 200);  
          return $newResponse;
        });
    });


     $app->group('/cdORM2', function () {   

        //$this->get('/',cdApi::class . ':traerTodos'); POR ERROR LO REEMPLAZO POR:
        $this->get('[/]',cdControler::class . ':traerTodos');
   
    });

};