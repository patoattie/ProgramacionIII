<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\cd;
use App\Models\ORM\cdControler;

include_once __DIR__ . '/../../src/app/models/ORM/cd.php';
include_once __DIR__ . '/../../src/app/models/ORM/cdControler.php';
include_once __DIR__ . '/../../src/app/models/ORM/usuario.php';
include_once __DIR__ . '/../../src/app/models/ORM/usuarioControler.php';

return function (App $app) {

	$app->group('/cds', function () {
		$container = $this->getContainer();

		$this->any('[/]', function (Request $request, Response $response, array $args) use ($container)
		{
			echo (new cdControler())->Bienvenida($request, $response, $args);
	  	});     

		$this->get('/listarCDs[/]', function (Request $request, Response $response, array $args) use ($container)
		{
			echo (new cdControler())->TraerTodos($request, $response, $args);
	  	});     

		$this->get('/listarCD[/{id}]', function (Request $request, Response $response, array $args) use ($container)
		{
			echo (new cdControler())->TraerUno($request, $response, $args);
	  	});     

		$this->post('/guardarCD[/]', function (Request $request, Response $response, array $args) use ($container)
		{
			echo (new cdControler())->CargarUno($request, $response, $args);
	  	});     

		$this->put('/guardarCD[/]', function (Request $request, Response $response, array $args) use ($container)
		{
			echo (new cdControler())->ModificarUno($request, $response, $args);
	  	});     

		$this->delete('/borrarCD[/]', function (Request $request, Response $response, array $args) use ($container)
		{
			echo (new cdControler())->BorrarUno($request, $response, $args);
	  	});     

	});	

	$app->group('/usuarios', function () {
		$container = $this->getContainer();

		$this->any('[/]', function (Request $request, Response $response, array $args) use ($container)
		{
			echo (new usuarioControler())->Bienvenida($request, $response, $args);
	  	});     

		$this->get('/listarUsuarios[/]', function (Request $request, Response $response, array $args) use ($container)
		{
			echo (new usuarioControler())->TraerTodos($request, $response, $args);
	  	});     

		$this->post('/altaUsuario[/]', function (Request $request, Response $response, array $args) use ($container)
		{
			echo (new usuarioControler())->CargarUno($request, $response, $args);
	  	});     

	});
};

?>