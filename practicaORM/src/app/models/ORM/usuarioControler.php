<?php
namespace App\Models\ORM;

use App\Models\ORM\usuario;
use App\Models\API\IApiControler;
use App\Models\API\AutentificadorJWT;

require_once __DIR__ . '/usuario.php';
include_once __DIR__ . '../../API/IApiControler.php';
include_once __DIR__ . '../../API/AutentificadorJWT.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class UsuarioControler implements IApiControler 
{
 	public function Bienvenida($request, $response, $args) {
		return $response->getBody()->write("<h1>" . $request->getMethod() . " => API de Usuarios</h1>
		<ul>
			<li>(GET)listarUsuarios: muestra todos los Usuarios cargados.</li>
            <li>(POST)altaUsuario: agrega el Usuario a la BD de acuerdo a los parámetros ingresados. Si la BD soporta ID autoincremental, el mismo se calcula, sino se solicita su ingreso por parámetro.<br>
                Estados devueltos:<br>
                ( 0) -> Insert OK<br>
                (-1) -> El Usuario ya está ingresado en la colección<br>
                (-2) -> Falta informar el parámetro ID<br>
                (-3) -> Falta ingresar password</li>
		</ul>");
    }
    
    public function TraerTodos($request, $response, $args) {
        //retorna un array de objetos de tipo usuario con todos los Usuarios de la colección
        $todosLosUsuarios=Usuario::all();

        $newResponse = $response->withJson($todosLosUsuarios, 200);  
        return $newResponse;
    }

    public function CargarUno($request, $response, $args) {
     	 //complete el codigo

        $condicion = self::cargarConBody($request);

        //cargo un objeto de tipo usuario con los parametros ingresados por POST
        $unUsuario = new Usuario();

        //cargo los atributos a ingresar en el objeto
        $unUsuario->setParams($condicion);

        //inserto en la base
        $estado = 0; //OK

        //Encripto la clave, si la misma existe, sino devuelvo error
        if($unUsuario->getClave())
        {
            $unUsuario->setClave($unUsuario->getClave());

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
        }
        else
        {
            $estado = -3; //"Falta ingresar password"
        }

        //Devuelvo el estado
        $newResponse = $response->withJson($estado, 200);
        return $newResponse;
    }

    public function TraerUno($request, $response, $args)
    {
        //complete el codigo
        $newResponse = "";

        //cargo un array con los parametros ingresados por GET
        $unUsuario = new Usuario();
        $condicion = self::cargarConBody($request);

        //retorna true si dentro de los parámetros ingresados está la Clave.
        $tengoClave = array_key_exists($unUsuario->getCampoClave(), $condicion);
        //retorna true si dentro de los parámetros ingresados está el Usuario.
        $tengoUsuario = array_key_exists($unUsuario->getCampoUsuario(), $condicion);

        //Si tengo usuario y clave lo valido
        if($tengoUsuario && $tengoClave)
        {
            $filtro = array();
            $filtro[$unUsuario->getCampoUsuario()] = $condicion[$unUsuario->getCampoUsuario()];

            //retorna un objeto de tipo usuario con el usuario solicitado.
            $unUsuario = $unUsuario->where($filtro)->get();

            if(isset($unUsuario[0]) && $unUsuario[0]->validarClave($condicion[$unUsuario[0]->getCampoClave()]))
            {
                //$newResponse = $response->withJson($unUsuario[0], 200);
                $newResponse = AutentificadorJWT::CrearToken($unUsuario[0], 200);
            }
        }

        return $newResponse;
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