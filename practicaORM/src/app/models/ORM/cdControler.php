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
            <li>(PUT)guardarCD: modifica un CD en la BD de acuerdo a los parámetros ingresados. Busca por parámetro ID, si no se lo proporciona retorna error.</li>
			<li>(DELETE)borrarCD: borra un CD en la BD de acuerdo al ID ingresado. Si no se lo proporciona retorna error.</li>
		</ul>");
    }
    
    public function TraerTodos($request, $response, $args) {
        $todosLosCds=cd::all();
        $newResponse = $response->withJson($todosLosCds, 200);  
        return $newResponse;
    }

    public function TraerUno($request, $response, $args) {
     	//complete el codigo

    	$condicion = array();

        //cargo un array con los parametros ingresados por GET
        self::cargarConQueryParams($request, $condicion);

		//traigo a un array de objetos de tipo cd los CDs que cumplen la condición dada por los parámetros
        $CDs = (new cd())->where($condicion)->get();

		$newResponse = $response->withJson($CDs, 200);

    	return $newResponse;
    }
   
    public function CargarUno($request, $response, $args) {
     	 //complete el codigo

		$respuesta = 0; //OK

        //cargo un objeto de tipo cd con los parametros ingresados por POST
        $unCD = new cd();
        self::cargarConBody($request, $unCD);

        //retorna true si dentro de los parámetros ingresados está el ID. Util para cuando el ID en la BD no es autoincremental y se lo tengo que pasar.
        $tengoClave = self::tieneID($unCD);

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

        $respuesta = 0; //OK

        //cargo un objeto de tipo cd con los parametros ingresados por DELETE
        $unCD = new cd();
        self::cargarConBody($request, $unCD);

        //retorna true si dentro de los parámetros ingresados está el ID. Util para cuando el ID en la BD no es autoincremental y se lo tengo que pasar.
        $tengoClave = self::tieneID($unCD);

        if($tengoClave) //tengo el ID ingresado dentro de los parámetros del body
        {
            //valor del ID
            $id = $unCD[$unCD->getKeyName()];

            //retorno un objeto con el ID solicitado.
            $unCD = (new cd())->find($id);

            if(!$unCD) //Si NO existe el ID, muestro mensaje al usuario y no borro nada
            {
                $respuesta = -1; //"El CD no existe"
                $newResponse = $response->withJson($respuesta, 200);  
            }
            else
            {
                $unCD->delete();
                $newResponse = $response->withJson($respuesta, 200);  //"CD borrado"
            }
        }
        else
        {
            $respuesta = -2; //"Falta pasar el parametro con el ID del CD a borrar"
            $newResponse = $response->withJson($respuesta, 200);  
        }

        return $newResponse;
    }
     
    public function ModificarUno($request, $response, $args) {
     	//complete el codigo

        $respuesta = 0; //OK

        //cargo un objeto de tipo cd con los parametros ingresados por PUT
        $unCD = new cd();
        self::cargarConBody($request, $unCD);

        //retorna true si dentro de los parámetros ingresados está el ID. Util para cuando el ID en la BD no es autoincremental y se lo tengo que pasar.
        $tengoClave = self::tieneID($unCD);

        if($tengoClave) //tengo el ID ingresado dentro de los parámetros del body
        {
            //valor del ID
            $id = $unCD[$unCD->getKeyName()];

            //retorno un objeto con el ID solicitado.
            $unCD = (new cd())->find($id);

            if(!$unCD) //Si NO existe el ID, muestro mensaje al usuario y no modifico nada
            {
                $respuesta = -1; //"El CD no existe"
                $newResponse = $response->withJson($respuesta, 200);  
            }
            else
            {
                //cargo los atributos a modificar en el objeto
                self::cargarConBody($request, $unCD);

                $unCD->save();
                $newResponse = $response->withJson($respuesta, 200);  //"CD modificado"
            }
        }
        else
        {
            $respuesta = -2; //"Falta pasar el parametro con el ID del CD a modificar"
            $newResponse = $response->withJson($respuesta, 200);  
        }

        return $newResponse;
    }

    private static function cargarConQueryParams($request, &$objeto)
    {
        //recorro los parámetros ingresados
        foreach ($request->getQueryParams() as $key => $value) //Parametros de $_GET
        {
            $objeto[$key] = $value;
        }
    }

    private static function cargarConBody($request, &$objeto)
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

        //cargo los atributos del objeto en un array, ya que no pueden ser directamente accedidos por foreach por estar protected.
        $atributos = $objeto->attributesToArray();

        foreach ($atributos as $key => $value)
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