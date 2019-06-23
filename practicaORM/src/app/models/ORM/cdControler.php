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
     	$newResponse = $response->withJson("sin completar", 200);  
    	return $newResponse;
    }
   
      public function CargarUno($request, $response, $args) {
     	 //complete el codigo
     	$newResponse = $response->withJson("sin completar", 200);  
        return $response;
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