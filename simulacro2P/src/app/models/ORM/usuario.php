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

	public function calculaID()
	{
		return $this->getIncrementing();
	}

	public function setClave($clave)
	{
		$this->setAttribute(self::getCampoClave(), password_hash($clave, PASSWORD_BCRYPT));
	}

	public function getClave()
	{
		return $this->getAttribute(self::getCampoClave());
	}

	public function setUsuario($usuario)
	{
		$this->setAttribute(self::getCampoUsuario(), $usuario);
	}

	public function getUsuario()
	{
		return $this->getAttribute(self::getCampoUsuario());
	}

	public function setSexo($sexo)
	{
		$this->setAttribute(self::getCampoSexo(), $sexo);
	}

	public function getSexo()
	{
		return $this->getAttribute(self::getCampoSexo());
	}

	public function setPerfil($perfil)
	{
		$this->setAttribute(self::getCampoPerfil(), $perfil);
	}

	public function getPerfil()
	{
		return $this->getAttribute(self::getCampoPerfil());
	}

	public function validarClave($clave)
	{
		return password_verify($clave, $this->getClave());
	}

	public function getCampoID()
	{
		return $this->getKeyName();
	}

	public static function getCampoUsuario()
	{
		return "nombre";
	}

	public static function getCampoClave()
	{
		return "clave";
	}

	public static function getCampoPerfil()
	{
		return "perfil";
	}

	public static function getCampoSexo()
	{
		return "sexo";
	}
}

?>