<?php
namespace App\Models\ORM;
 
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class cd extends \Illuminate\Database\Eloquent\Model
{ 
	public $timestamps = false; 
	
	//retorna un array de objetos de tipo cd con todos los CDs de la colección
	public static function traerTodos()
	{
		return self::all();
	}

	//retorna un array de objetos de tipo cd con los CDs que cumplen la condición dada en el parámetro condición, el cual es un array de clave/valor.
	public static function traerPorParams($condicion)
	{
		return (new cd())->where($condicion)->get();
	}

	//retorna un objeto de tipo cd con el CD cuyo ID coincida con el parámetro ID ingresado, el cual se extrae del array pasado por parámetro.
	public static function traerPorPK($condicion)
	{
		return (new cd())->where($condicion)->get();
	}
}

?>