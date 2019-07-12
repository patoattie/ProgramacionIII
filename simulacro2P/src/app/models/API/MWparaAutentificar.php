<?php
namespace App\Models\API;

use App\Models\ORM\usuario;
use Exception;

require_once "AutentificadorJWT.php";
include_once __DIR__ . '/../ORM/usuario.php';

class MWparaAutentificar
{
 /**
   * @api {any} /MWparaAutenticar/  Verificar Usuario
   * @apiVersion 0.1.0
   * @apiName VerificarUsuario
   * @apiGroup MIDDLEWARE
   * @apiDescription  Por medio de este MiddleWare verifico las credeciales antes de ingresar al correspondiente metodo 
   *
   * @apiParam {ServerRequestInterface} request  El objeto REQUEST.
 * @apiParam {ResponseInterface} response El objeto RESPONSE.
 * @apiParam {Callable} next  The next middleware callable.
   *
   * @apiExample Como usarlo:
   *    ->add(\MWparaAutenticar::class . ':VerificarUsuario')
   */
	public function VerificarUsuario($request, $response, $next) {
         
		$objDelaRespuesta = new \stdclass();
		$objDelaRespuesta->respuesta = "";
		$newResponse = "";
	   
		/*if($request->isGet())
		{
		// $response->getBody()->write('<p>NO necesita credenciales para los get </p>');
			$response = $next($request, $response);
		}
		else
		{*/
			//$datos = array('usuario' => 'rogelio@agua.com','perfil' => 'Administrador', 'alias' => "PinkBoy");
			/*$datos = array(Usuario::getCampoUsuario() => $request->getParsedBodyParam(Usuario::getCampoUsuario()), Usuario::getCampoPerfil() => $request->getParsedBodyParam(Usuario::getCampoPerfil()), Usuario::getCampoSexo() => $request->getParsedBodyParam(Usuario::getCampoSexo()));

			$token = AutentificadorJWT::CrearToken($datos);*/

  			$token = $request->getHeader("jwt")[0];

			//tomo el token del header
			/*
				$arrayConToken = $request->getHeader('token');
				$token=$arrayConToken[0];			
			*/
			//var_dump($token);
			$objDelaRespuesta->esValido = true; 
			try 
			{
				//$token="";
				AutentificadorJWT::verificarToken($token);
			}
			catch (Exception $e)
			{      
				//guardar en un log
				$objDelaRespuesta->excepcion = $e->getMessage();
				$objDelaRespuesta->esValido = false;     
			}

			if($objDelaRespuesta->esValido)
			{						
				if(!$request->isPost() && !$request->isGet()) // el post y el get sirven para todos los logueados
				{
					$payload = AutentificadorJWT::ObtenerData($token);
		  			$perfil = Usuario::getCampoPerfil();

					// PUT y DELETE sirve para solamente para los logeados y admin
					if($payload->$perfil !== Usuario::getPerfilAdmin())
					{	
						$objDelaRespuesta->esValido = false;
						$objDelaRespuesta->respuesta = "Solo Administradores";
					}
				}		          
			}    
			else
			{
				$objDelaRespuesta->respuesta = "Solo usuarios registrados";
				//$objDelaRespuesta->elToken = $token;
			}

			//Atributo que usarán los demás middleware para saber si el usuario está autenticado
			$request = $request->withAttribute("usuarioHabilitado", $objDelaRespuesta->esValido);

			if($objDelaRespuesta->esValido) 
			{
				$response = $next($request, $response);
			}

		//}

		if($objDelaRespuesta->respuesta != "")
		{
			$newResponse = $response->write($response->withJson($objDelaRespuesta->respuesta, 401));  
		}
		else
		{
			$newResponse = $response;
		}
		  
		 //$response->getBody()->write('<p>vuelvo del verificador de credenciales</p>');
		 return $newResponse;   
	}

	public function GetFiltrarAdmin($request, $response, $next)
	{
		$newResponse = "";

		if($request->getAttribute("usuarioHabilitado"))
		{
			$objDelaRespuesta = new \stdclass();
			$objDelaRespuesta->respuesta = "";
		   
			$token = $request->getHeader("jwt")[0];

			$payload = AutentificadorJWT::ObtenerData($token);
			$perfil = Usuario::getCampoPerfil();

			if($payload->$perfil === Usuario::getPerfilAdmin())
			{
				$response = $next($request, $response);
			}		           	
			else
			{
				$objDelaRespuesta->respuesta = "hola";
			}

			if($objDelaRespuesta->respuesta != "")
			{
				$newResponse = $response->write($response->withJson($objDelaRespuesta->respuesta, 200));  
			}
			else
			{
				$newResponse = $response;
			}
		}
		else //El usuario no está habilitado
		{
			$newResponse = $response;
		}
		  
		return $newResponse;   
	}
}