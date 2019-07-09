<?php
namespace App\Models\API;

use App\Models\ORM\usuario;

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
	   
		if($request->isGet())
		{
		// $response->getBody()->write('<p>NO necesita credenciales para los get </p>');
			$response = $next($request, $response);
		}
		else
		{
			//$datos = array('usuario' => 'rogelio@agua.com','perfil' => 'Administrador', 'alias' => "PinkBoy");
			$datos = array(Usuario::getCampoUsuario() => $request->getParsedBodyParam(Usuario::getCampoUsuario()), Usuario::getCampoPerfil() => $request->getParsedBodyParam(Usuario::getCampoPerfil()), Usuario::getCampoSexo() => $request->getParsedBodyParam(Usuario::getCampoSexo()));

			$token = AutentificadorJWT::CrearToken($datos);

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
				$objDelaRespuesta->esValido = true;      
			}
			catch (Exception $e) {      
				//guardar en un log
				$objDelaRespuesta->excepcion = $e->getMessage();
				$objDelaRespuesta->esValido = false;     
			}

			if($objDelaRespuesta->esValido)
			{						
				if($request->isPost())
				{
					$request = $request->withAttribute("jwt", $token);

					// el post sirve para todos los logeados			    
					$response = $next($request, $response);
				}
				else
				{
					$payload = AutentificadorJWT::ObtenerData($token);
					//var_dump($payload);
					// PUT y DELETE sirve para solamente para los logeados y admin
					//if($payload->perfil=="admin")
					if($payload[Usuario::getCampoPerfil()] === Usuario::getPerfilAdmin())
					{
						$request = $request->withAttribute("jwt", $token);
						$response = $next($request, $response);
					}		           	
					else
					{	
						$objDelaRespuesta->respuesta = "Solo Administradores";
					}
				}		          
			}    
			else
			{
				//   $response->getBody()->write('<p>no tenes habilitado el ingreso</p>');
				$objDelaRespuesta->respuesta = "Solo usuarios registrados";
				$objDelaRespuesta->elToken = $token;

			}  
		}

		if($objDelaRespuesta->respuesta != "")
		{
			//$nueva=$response->withJson($objDelaRespuesta, 401);  
			//return $nueva;
			$newResponse = $response->withJson($objDelaRespuesta, 401);  
		}
		else
		{
			$newResponse = $response;
		}
		  
		 //$response->getBody()->write('<p>vuelvo del verificador de credenciales</p>');
		 return $newResponse;   
	}
}