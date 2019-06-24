<?php
namespace App\Models\ORM;

use App\Models\ORM\cd;
use App\Models\API\IApiControler;

require_once __DIR__ . '/cd.php';
include_once __DIR__ . '../../API/IApiControler.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class cdControler implements IApiControler 
{
 	public function Bienvenida($request, $response, $args) {
	    return $response->getBody()->write("<h1>" . $request->getMethod() . " => API de CDs</h1> <ul><li>(GET)listarCDs: muestra todos los CDs cargados</li></ul>");
    }
    
    public function TraerTodos($request, $response, $args) {
        $todosLosCds=cd::all();
        $newResponse = $response->withJson($todosLosCds, 200);  
        return $newResponse;
    }

    public function TraerUno($request, $response, $args) {
     	//complete el codigo
     	//var_dump($request->getQueryParams());

    	$condicion = array();

     	//recorro los parámetros ingresados
     	foreach ($request->getQueryParams() as $key => $value) //Parametros de $_GET
     	{
			$condicion[$key] = $value;
     	}

		$CDs = (new cd())->where($condicion)->get();

 		if($CDs->isEmpty()) //en vendor/illuminate/support/Collection.php:1020
 		{
 			//La búsqueda no retornó ningún resultado, por lo tanto el array $CDs está vacío.
 			$newResponse = $response->withJson("No existe el CD requerido", 200);
 		}
 		else
 		{
     		$newResponse = $response->withJson($CDs, 200);
 		}

    	return $newResponse;
    }
   
    public function CargarUno($request, $response, $args) {
     	 //complete el codigo

      	$unCD = new cd();
      	$tengoClave = false;

     	//recorro los parámetros ingresados
     	foreach ($request->getParsedBody() as $key => $value) //Parametros de $_POST
     	{
			$unCD[$key] = $value;

			if($key == $unCD->getKeyName())
			{
				$tengoClave = true;
			}
     	}

     	if($unCD->getIncrementing()) //El ID es autoincremental, lo dejo en nulo para que lo calcule la BD.
     	{
     		$unCD[$unCD->getKeyName()] = null;
     		$unCD->save();
     		$newResponse = $response->withJson("CD ingresado a la coleccion", 200);  
     	}
     	else
     	{
     		if($tengoClave) //Como no es autoincremental el ID, valido que se haya ingresado en el body.
     		{
     			if($unCD->find($unCD[$unCD->getKeyName()])) //Si existe el ID, muestro mensaje al usuario y no ingreso nada
     			{
     				$newResponse = $response->withJson("El CD ya se encuentra ingresado", 200);  
     			}
     			else
     			{
		     		$unCD->save();
		     		$newResponse = $response->withJson("CD ingresado a la coleccion", 200);  
     			}
     		}
     		else
     		{
     			$newResponse = $response->withJson("Falta pasar el parametro con el ID del CD a cargar", 200);  
     		}
     	}

        return $newResponse;
    }

    public function BorrarUno($request, $response, $args) {
  		//complete el codigo
     	$newResponse = $response->withJson("sin completar", 200);  
      	return $newResponse;
    }
     
    public function ModificarUno($request, $response, $args) {
     	//complete el codigo
     	$newResponse = $response->withJson("sin completar", 200);  
		return 	$newResponse;
    }


  
}

?>