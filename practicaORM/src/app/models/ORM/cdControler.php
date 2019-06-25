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
		return $response->getBody()->write("<h1>" . $request->getMethod() . " => API de CDs</h1>
		<ul>
			<li>(GET)listarCDs: muestra todos los CDs cargados.</li>
			<li>(GET)listarCD: muestra todos los CDs cargados que satisfagan los parámetros ingresados.</li>
			<li>(POST)guardarCD: agrega el CD a la BD de acuerdo a los parámetros ingresados. Si la BD soporta ID autoincremental, el mismo se calcula, sino se solicita su ingreso por parámetro.</li>
		</ul>");
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
     	/*foreach ($request->getQueryParams() as $key => $value) //Parametros de $_GET
     	{
			$condicion[$key] = $value;
     	}*/

        static::cargarConGET($request, $condicion);

		$CDs = (new cd())->where($condicion)->get();

		$newResponse = $response->withJson($CDs, 200);

    	return $newResponse;
    }
   
    public function CargarUno($request, $response, $args) {
     	 //complete el codigo

      	$unCD = new cd();
      	//$tengoClave = false;

		$respuesta = 0; //OK

		
		//recorro los parámetros ingresados
     	/*foreach ($request->getParsedBody() as $key => $value) //Parametros de $_POST
     	{
			$unCD[$key] = $value;

			if($key == $unCD->getKeyName())
			{
				$tengoClave = true;
			}
     	}*/

        static::cargarConPOST($request, $unCD);

        $tengoClave = static::tieneID($unCD);

     	if($unCD->getIncrementing()) //El ID es autoincremental, lo dejo en nulo para que lo calcule la BD.
     	{
     		$unCD[$unCD->getKeyName()] = null;
     		$unCD->save();
     		$newResponse = $response->withJson($respuesta, 200);  //"CD ingresado a la coleccion"
     	}
     	else
     	{
     		if($tengoClave) //Como no es autoincremental el ID, valido que se haya ingresado en el body.
     		{
     			if($unCD->find($unCD[$unCD->getKeyName()])) //Si existe el ID, muestro mensaje al usuario y no ingreso nada
     			{
					$respuesta = -1; //"El CD ya se encuentra ingresado"
     				$newResponse = $response->withJson($respuesta, 200);  
     			}
     			else
     			{
		     		$unCD->save();
		     		$newResponse = $response->withJson($respuesta, 200);  //"CD ingresado a la coleccion"
     			}
     		}
     		else
     		{
				$respuesta = -2; //"Falta pasar el parametro con el ID del CD a cargar"
				$newResponse = $response->withJson($respuesta, 200);  
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

    private static function cargarConGET($request, &$objeto)
    {
        //recorro los parámetros ingresados
        foreach ($request->getQueryParams() as $key => $value) //Parametros de $_GET
        {
            $objeto[$key] = $value;
        }
    }

    private static function cargarConPOST($request, &$objeto)
    {
        //recorro los parámetros ingresados
        foreach ($request->getParsedBody() as $key => $value) //Parametros de $_POST
        {
            $objeto[$key] = $value;
        }
    }

    private static function tieneID($objeto)
    {
        $tieneID = false;

        foreach ($objeto as $key => $value)
        {
            if($key == $objeto->getKeyName())
            {
                $tieneID = true;
                break;
            }
        }

        return $tieneID;
    }
  
}

?>