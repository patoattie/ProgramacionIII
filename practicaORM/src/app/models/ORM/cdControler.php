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
            <li>(POST)guardarCD: agrega el CD a la BD de acuerdo a los parámetros ingresados. Si la BD soporta ID autoincremental, el mismo se calcula, sino se solicita su ingreso por parámetro.<br>
                Estados devueltos:<br>
                ( 0) -> Insert OK<br>
                (-1) -> El CD ya está ingresado en la colección<br>
                (-2) -> Falta informar el parámetro ID</li>
            <li>(PUT)guardarCD: modifica un CD en la BD de acuerdo a los parámetros ingresados. Busca por parámetro ID, si no se lo proporciona retorna error.<br>
                Estados devueltos:<br>
                ( 0) -> Update OK<br>
                (-1) -> El CD no existe en la colección<br>
                (-2) -> Falta informar el parámetro ID</li>
			<li>(DELETE)borrarCD: borra un CD en la BD de acuerdo al ID ingresado. Si no se lo proporciona retorna error.<br>
                Estados devueltos:<br>
                ( 0) -> Delete OK<br>
                (-1) -> El CD no existe en la colección<br>
                (-2) -> Falta informar el parámetro ID</li>
		</ul>");
    }
    
    public function TraerTodos($request, $response, $args) {
        //retorna un array de objetos de tipo cd con todos los CDs de la colección
        $todosLosCds=cd::all();

        $newResponse = $response->withJson($todosLosCds, 200);  
        return $newResponse;
    }

    public function TraerUno($request, $response, $args) {
     	//complete el codigo

        //cargo un array con los parametros ingresados por GET
        $condicion = self::cargarConQueryParams($request);

		//retorna un array de objetos de tipo cd con los CDs que cumplen la condición dada en el parámetro condición, el cual es un array de clave/valor.
        $CDs = (new cd())->where($condicion)->get();

        $newResponse = $response->withJson($CDs, 200);
    	return $newResponse;
    }
   
    public function CargarUno($request, $response, $args) {
     	 //complete el codigo

        $condicion = self::cargarConBody($request);

        //cargo un objeto de tipo cd con los parametros ingresados por POST
        $unCD = new cd();

        //cargo los atributos a ingresar en el objeto
        $unCD->setParams($condicion);

        //inserto en la base
        $estado = 0; //OK

     	if($unCD->calculaID()) //El ID es autoincremental, lo dejo en nulo para que lo calcule la BD.
     	{
     		$unCD->setID(null);
     		$unCD->save();
     	}
     	else
     	{
            //retorna true si dentro de los parámetros ingresados está el ID. Util para cuando el ID en la BD no es autoincremental y se lo tengo que pasar.
            $tengoClave = array_key_exists($unCD->getCampoID(), $condicion);

            if($tengoClave) //tengo el ID ingresado dentro de los parámetros del body
     		{
                //traigo el id de los parámetros ingresados
                $id = $condicion[$unCD->getCampoID()];

     			if($unCD->find($id)) //Si existe el ID, muestro mensaje al usuario y no ingreso nada
     			{
					$estado = -1; //"El CD ya se encuentra ingresado"
     			}
     			else
     			{
		     		$unCD->save();
     			}
     		}
     		else
     		{
				$estado = -2; //"Falta pasar el parametro con el ID del CD a cargar"
     		}
     	}

        //Devuelvo el estado
        $newResponse = $response->withJson($estado, 200);
        return $newResponse;
    }

    public function BorrarUno($request, $response, $args) {
  		//complete el codigo

        //cargo un objeto de tipo cd con los parametros ingresados por DELETE
        $unCD = new cd();
        $condicion = self::cargarConBody($request);

        //borro en la base
        $estado = 0; //OK

        //retorna true si dentro de los parámetros ingresados está el ID. Util para cuando el ID en la BD no es autoincremental y se lo tengo que pasar.
        $tengoClave = array_key_exists($unCD->getCampoID(), $condicion);

        if($tengoClave) //tengo el ID ingresado dentro de los parámetros del body
        {
            //traigo el id de los parámetros ingresados
            $id = $condicion[$unCD->getCampoID()];

            //retorno un objeto con el ID solicitado.
            $unCD = $unCD->find($id);

            if(!$unCD) //Si NO existe el ID, muestro mensaje al usuario y no borro nada
            {
                $estado = -1; //"El CD no existe"
            }
            else
            {
                $unCD->delete();
            }
        }
        else
        {
            $estado = -2; //"Falta pasar el parametro con el ID del CD a borrar"
        }

        //Devuelvo el estado
        $newResponse = $response->withJson($estado, 200);  
        return $newResponse;
    }
     
    public function ModificarUno($request, $response, $args) {
     	//complete el codigo

        //cargo un objeto de tipo cd con los parametros ingresados por PUT
        $unCD = new cd();
        $condicion = self::cargarConBody($request);

        //modifico en la base
        $estado = 0; //OK

        //retorna true si dentro de los parámetros ingresados está el ID. Util para cuando el ID en la BD no es autoincremental y se lo tengo que pasar.
        $tengoClave = array_key_exists($unCD->getCampoID(), $condicion);

        if($tengoClave) //tengo el ID ingresado dentro de los parámetros del body
        {
            //traigo el id de los parámetros ingresados
            $id = $condicion[$unCD->getCampoID()];

            //retorno un objeto con el ID solicitado.
            $unCD = $unCD->find($id);

            if(!$unCD) //Si NO existe el ID, muestro mensaje al usuario y no modifico nada
            {
                $estado = -1; //"El CD no existe"
            }
            else
            {
                //cargo los atributos a ingresar en el objeto
                $unCD->setParams($condicion);

                $unCD->save();
            }
        }
        else
        {
            $estado = -2; //"Falta pasar el parametro con el ID del CD a modificar"
        }

        //Devuelvo el estado
        $newResponse = $response->withJson($estado, 200);  
        return $newResponse;
    }

    private static function cargarConQueryParams($request)
    {
        $parametros = array();

        //recorro los parámetros ingresados
        foreach ($request->getQueryParams() as $key => $value) //Parametros de $_GET
        {
            $parametros[$key] = $value;
        }

        return $parametros;
    }

    private static function cargarConBody($request)
    {
        $parametros = array();

        //recorro los parámetros ingresados
        foreach ($request->getParsedBody() as $key => $value) //Parametros de $_POST
        {
            $parametros[$key] = $value;
        }

        return $parametros;
    }
}

?>