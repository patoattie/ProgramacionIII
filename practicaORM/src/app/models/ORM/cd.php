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

	//carga los valores de los atributos contenidos en el array pasado por parámetro
	public function setParams($parametros)
	{
        //cargo los atributos a ingresar en el objeto
        foreach ($parametros as $key => $value)
        {
            $this->setAttribute($key, $value);
        }
	}

	public function setID($id)
	{
		$this->setAttribute($this->getCampoID(), $id);
	}

	public function getID()
	{
		return $this->getAttribute($this->getCampoID());
	}

	public function getCampoID()
	{
		return $this->getKeyName();
	}

	public function calculaID()
	{
		return $this->getIncrementing();
	}

	public function insertar()
	{
        $respuesta = 0; //OK

     	if($this->calculaID()) //El ID es autoincremental, lo dejo en nulo para que lo calcule la BD.
     	{
     		$this->setID(null);
     		$this->save();
     	}
     	else
     	{
            //retorna true si dentro de los parámetros ingresados está el ID. Util para cuando el ID en la BD no es autoincremental y se lo tengo que pasar.
            $id = $this->getID();

     		if($id) //Como no es autoincremental el ID, valido que se haya ingresado en el body.
     		{
     			if($this->find($id)) //Si existe el ID, muestro mensaje al usuario y no ingreso nada
     			{
					$respuesta = -1; //"El CD ya se encuentra ingresado"
     			}
     			else
     			{
		     		$this->save();
     			}
     		}
     		else
     		{
				$respuesta = -2; //"Falta pasar el parametro con el ID del CD a cargar"
     		}
     	}

     	return $respuesta;
	}

	public function modificar()
	{
        $respuesta = 0; //OK

        //retorna true si dentro de los parámetros ingresados está el ID. Util para cuando el ID en la BD no es autoincremental y se lo tengo que pasar.
        $id = $this->getID();

        if($id) //tengo el ID ingresado dentro de los parámetros del body
        {
            //retorno un objeto con el ID solicitado.
            //$unCD = $unCD->find($id);

            if(!$this->find($id)) //Si NO existe el ID, muestro mensaje al usuario y no modifico nada
            {
                $respuesta = -1; //"El CD no existe"
            }
            else
            {
                $this->save();
            }
        }
        else
        {
            $respuesta = -2; //"Falta pasar el parametro con el ID del CD a modificar"
        }

        return $respuesta;
	}
}

?>