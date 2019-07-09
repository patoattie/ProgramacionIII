<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\usuario;
use App\Models\ORM\usuarioControler;
use App\Models\API\MWparaAutentificar;
use App\Models\API\AutentificadorJWT;

include_once __DIR__ . '/../../src/app/models/ORM/usuario.php';
include_once __DIR__ . '/../../src/app/models/ORM/usuarioControler.php';
include_once __DIR__ . '/../../src/app/models/API/MWparaAutentificar.php';
include_once __DIR__ . '/../../src/app/models/API/AutentificadorJWT.php';

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
	  	})->add(function($request, $response, $next) //middleware
		  	{
		  		$token = "";

		  		if(null !== $request->getQueryParam("jwt"))
		  		{
		  			$token = $request->getQueryParam("jwt");
		  		}
		  		else
		  		{
			  		$token = $request->getAttribute("jwt");
		  		}

		  		$tokenValido = true;
				$error = "";
		  		$newResponse = "";

				try 
				{
					AutentificadorJWT::verificarToken($token);
				}
				catch (Exception $e)
				{      
					//guardar en un log
					$error = $e->getMessage();
					$tokenValido = false;     
				}

		  		if($tokenValido)
		  		{
		  			$datos = AutentificadorJWT::ObtenerData($token);
		  			$perfil = Usuario::getCampoPerfil();

		  			if($datos->$perfil === Usuario::getPerfilAdmin())
		  			{
		  				$response = $next($request, $response);
		  			}
		  			else
		  			{
		  				$error = "hola";
		  			}
		  		}
		  		/*else
		  		{
		  			$error = "No esta logueado";
		  		}*/

		  		if($error !== "")
		  		{
		  			$newResponse = $response->withJson($error, 401);
		  		}
		  		else
		  		{
		  			$newResponse = $response;
		  		}

		  		return $newResponse;
		  	});     

		$this->post('[/]', function (Request $request, Response $response, array $args) use ($container)
		{
			echo (new usuarioControler())->CargarUno($request, $response, $args);
	  	})->add(function($request, $response, $next) //middleware
			{
				$request = $request->withParsedBody(array(Usuario::getCampoUsuario() => $request->getParsedBodyParam(Usuario::getCampoUsuario()), Usuario::getCampoClave() => $request->getParsedBodyParam(Usuario::getCampoClave()), Usuario::getCampoPerfil() => "usuario", Usuario::getCampoSexo() => $request->getParsedBodyParam(Usuario::getCampoSexo()), "id" => $request->getParsedBodyParam("id")));

				$response = $next($request, $response);

				return $response;
			});     

		/*$this->post('/altaAdminPorDefecto[/]', function (Request $request, Response $response, array $args) use ($container)
		{
			echo (new usuarioControler())->CargarUno($request, $response, $args);
	  	})->add(function($request, $response, $next) //middleware
			{
				$request = $request->withParsedBody(array(Usuario::getCampoUsuario() => "admin", Usuario::getCampoClave() => "admin", Usuario::getCampoPerfil() => "admin", Usuario::getCampoSexo() => "femenino", "id" => "1"));

				$response = $next($request, $response);

				return $response;
			});*/
	  	//})->add(MWparaAutentificar::class . ':crearAdminPorDefecto');
	});

	$app->group('/login', function ()
	{
		$container = $this->getContainer();

		$this->post('[/]', function (Request $request, Response $response, array $args) use ($container)
		{
			echo (new usuarioControler())->Login($request, $response, $args);
	  	});     
	});//->add(MWparaAutentificar::class . ':VerificarUsuario');
};

?>