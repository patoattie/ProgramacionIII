<?php
namespace App\Models\ORM;
 
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Usuario extends \Illuminate\Database\Eloquent\Model
{ 
	//public $timestamps = false; 
	
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

	public function setClave($clave)
	{
		$this->setAttribute($this->getCampoClave(), password_hash($clave, PASSWORD_BCRYPT));
	}

	public function getClave()
	{
		return $this->getAttribute($this->getCampoClave());
	}

	public function getUsuario()
	{
		return $this->getAttribute($this->getCampoUsuario());
	}

	public function validarClave($clave)
	{
		return password_verify($clave, $this->getClave());
	}

	public function getCampoClave()
	{
		return "clave";
	}

	public function getCampoUsuario()
	{
		return "nombre";
	}
}

?>