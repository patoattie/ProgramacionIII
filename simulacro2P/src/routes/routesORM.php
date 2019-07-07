<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\usuario;
use App\Models\ORM\usuarioControler;
use App\Models\API\MWparaAutentificar;

include_once __DIR__ . '/../../src/app/models/ORM/usuario.php';
include_once __DIR__ . '/../../src/app/models/ORM/usuarioControler.php';
include_once __DIR__ . '/../../src/app/models/API/MWparaAutentificar.php';

return function (App $app) {

	$app->group('/usuarios', function ()
	{
		$container = $this->getContainer();

		$this->any('[/]', function (Request $request, Response $response, array $args) use ($container)
		{
			echo (new usuarioControler())->Bienvenida($request, $response, $args);
	  	});     
	});

	$app->group('/usuario', function ()
	{
		$container = $this->getContainer();

		$this->get('[/]', function (Request $request, Response $response, array $args) use ($container)
		{
			echo (new usuarioControler())->TraerTodos($request, $response, $args);
	  	});     

		$this->post('[/]', function (Request $request, Response $response, array $args) use ($container)
		{
			echo (new usuarioControler())->CargarUno($request, $response, $args);
	  	});     

		$this->post('/altaAdmin[/]', function (Request $request, Response $response, array $args) use ($container)
		{
			echo (new usuarioControler())->CargarUno($request, $response, $args);
	  	})->add(MWparaAutentificar::class . ':crearAdmin');     

		$this->post('/validarUsuario[/]', function (Request $request, Response $response, array $args) use ($container)
		{
			echo (new usuarioControler())->TraerUno($request, $response, $args);
	  	});     
	});

	$app->group('/login', function ()
	{
		$container = $this->getContainer();

		$this->post('[/]', function (Request $request, Response $response, array $args) use ($container)
		{
			echo (new usuarioControler())->TraerUno($request, $response, $args);
	  	});     
	});
};

?>