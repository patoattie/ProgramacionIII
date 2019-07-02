<?php
namespace App\Models\ORM;

use App\Models\ORM\usuario;
use App\Models\API\IApiControler;

require_once __DIR__ . '/usuario.php';
include_once __DIR__ . '../../API/IApiControler.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class usuarioControler implements IApiControler 
{
 	public function Bienvenida($request, $response, $args) {
		return $response->getBody()->write("<h1>" . $request->getMethod() . " => API de Usuarios</h1>
		<ul>
			<li>(GET)listarUsuarios: muestra todos los Usuarios cargados.</li>
            <li>(POST)altaUsuario: agrega el Usuario a la BD de acuerdo a los parámetros ingresados. Si la BD soporta ID autoincremental, el mismo se calcula, sino se solicita su ingreso por parámetro.<br>
                Estados devueltos:<br>
                ( 0) -> Insert OK<br>
                (-1) -> El Usuario ya está ingresado en la colección<br>
                (-2) -> Falta informar el parámetro ID</li>
		</ul>");
    }
    
    public function TraerTodos($request, $response, $args) {
        //retorna un array de objetos de tipo usuario con todos los Usuarios de la colección
        $todosLosUsuarios=usuario::all();

        $newResponse = $response->withJson($todosLosUsuarios, 200);  
        return $newResponse;
    }

    public function CargarUno($request, $response, $args) {
     	 //complete el codigo

        $condicion = self::cargarConBody($request);

        //cargo un objeto de tipo usuario con los parametros ingresados por POST
        $unUsuario = new usuario();

        //cargo los atributos a ingresar en el objeto
        $unUsuario->setParams($condicion);

        //inserto en la base
        $estado = 0; //OK

     	if($unUsuario->calculaID()) //El ID es autoincremental, lo dejo en nulo para que lo calcule la BD.
     	{
     		$unUsuario->setID(null);
     		$unUsuario->save();
     	}
     	else
     	{
            //retorna true si dentro de los parámetros ingresados está el ID. Util para cuando el ID en la BD no es autoincremental y se lo tengo que pasar.
            $tengoClave = array_key_exists($unUsuario->getCampoID(), $condicion);

            if($tengoClave) //tengo el ID ingresado dentro de los parámetros del body
     		{
                //traigo el id de los parámetros ingresados
                $id = $condicion[$unUsuario->getCampoID()];

     			if($unUsuario->find($id)) //Si existe el ID, muestro mensaje al usuario y no ingreso nada
     			{
					$estado = -1; //"El Usuario ya se encuentra ingresado"
     			}
     			else
     			{
		     		$unUsuario->save();
     			}
     		}
     		else
     		{
				$estado = -2; //"Falta pasar el parametro con el ID del Usuario a cargar"
     		}
     	}

        //Devuelvo el estado
        $newResponse = $response->withJson($estado, 200);
        return $newResponse;
    }

    public function TraerUno($request, $response, $args)
    {

    }

    public function BorrarUno($request, $response, $args)
    {

    }

    public function ModificarUno($request, $response, $args)
    {

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