<?php

class Usuario
{
	private $id;
	private $email;
	private $clave;
	private $alias;
	private $fecha;

	public function __construct($email, $clave, $alias, $id = 0, $fecha = "")
	{
		$this->email = $email;
		$this->clave = $clave;
		$this->alias = $alias;

		if ($id === 0)
		{
			$this->id = Usuario::siguienteId(Usuario::leerUsuarios());
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

	public static function leerUsuarios()
	{
		$archivo = fopen("archivos/usuarios.txt", "r");
		$arrayUsuarios = array();
		$arrayDatos = array();
		$linea = "";

		while (!feof($archivo))
		{
			$linea = fgets($archivo);

			if ((string)$linea != "") //Evito las lineas vacias
			{
				$arrayDatos = json_decode($linea, true); //El segundo parametro en true para que trate la salida como array.
				$usuario = new Usuario($arrayDatos["email"], $arrayDatos["clave"], $arrayDatos["alias"], $arrayDatos["id"], $arrayDatos["fecha"]);
				array_push($arrayUsuarios, $usuario);
			}
		}

		fclose($archivo);
		return $arrayUsuarios;
	}

	public static function siguienteId($arrayUsuarios)
	{
		$proximoId = 0;
		if (isset($arrayUsuarios))
		{
			foreach ($arrayUsuarios as $usuario)
			{
				if ($usuario->id > $proximoId)
				{
					$proximoId = $usuario->id;
				}
			}
		}

		return $proximoId + 1;
	}

	public static function guardarUsuario($usuario)
	{
		$linea = json_encode($usuario->toArray());
		$archivo = fopen("archivos/usuarios.txt", "a");
		fputs($archivo, $linea . "\n");
		fclose($archivo);
	}

	public function toArray()
	{
		$retorno = array();

		$retorno["email"] = trim($this->email);
		$retorno["clave"] = trim($this->clave);
		$retorno["alias"] = trim($this->alias);
		$retorno["id"] = trim($this->id);
		$retorno["fecha"] = trim($this->fecha);

		return $retorno;
	}
}

?>