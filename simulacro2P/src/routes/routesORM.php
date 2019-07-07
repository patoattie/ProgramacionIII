<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\usuario;
use App\Models\ORM\usuarioControler;

include_once __DIR__ . '/../../src/app/models/ORM/usuario.php';
include_once __DIR__ . '/../../src/app/models/ORM/usuarioControler.php';

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
			$admin = array();
			$admin["nombre"] = "admin";
			$admin["clave"] = "admin";
			$admin["sexo"] = "femenino";
			echo (new usuarioControler())->CargarUno($admin, $response, $args);
	  	});     

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