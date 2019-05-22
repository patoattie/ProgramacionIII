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
			$arrayUsuarios = Usuario::leerUsuarios();
			$this->id = Usuario::siguienteId($arrayUsuarios);
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
	}

	public static function siguienteId($arrayUsuarios)
	{
		$proximoId = 0;

		foreach ($arrayUsuarios as $clave => $id)
		{
			if ($clave === "id" && $id > $proximoId)
			{
				$proximoId = $id;
			}
		}

		return $proximoId + 1;
	}
}

?>