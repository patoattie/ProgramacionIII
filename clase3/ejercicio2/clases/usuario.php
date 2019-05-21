<?php

class Usuario
{
	private $id;
	private $email;
	private $clave;
	private $alias;
	private $fecha;
	private static $proximoId;

	public function __construct($email, $clave, $alias, $id = 0, $fecha = "")
	{
		$this->email = $email;
		$this->clave = $clave;
		$this->alias = $alias;

		if ($id === 0)
		{
			$this->id = 
		}
		else
		{
			$this->id = $id;
		}

		if ($fecha === "")
		{
			$this->fecha = date("d/m/Y H:i:s");
		}
		else
		{
			$this->fecha = $fecha;
		}
	}

	public function leerUsuarios()
	{
		$archivo = fopen("archivos/usuarios.txt", "r");
		$arrayUsuarios = array();

		while (!feof($archivo))
		{
			$usuario = new Usuario()
		}
	}
}

?>