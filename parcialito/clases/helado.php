<?php

class Helado
{
	private $sabor;
	private $tipo;
	private $stock;
	private $precio;

	public function __construct($tipo, $sabor, $stock, $precio)
	{
		$this->tipo = $tipo;
		$this->sabor = $sabor;
		$this->stock = $stock;
		$this->precio = $precio;
	}

	public static function leerHelados()
	{
		$archivo = fopen("archivos/Helados.txt", "r");
		$arrayHelados = array();
		$arrayDatos = array();
		$linea = "";

		while (!feof($archivo))
		{
			$linea = fgets($archivo);

			if ((string)$linea != "") //Evito las lineas vacias
			{
				$arrayDatos = json_decode($linea, true); //El segundo parametro en true para que trate la salida como array.
				$Helado = new Helado($arrayDatos["tipo"], $arrayDatos["sabor"], $arrayDatos["stock"], $arrayDatos["id"], $arrayDatos["precio"]);
				array_push($arrayHelados, $Helado);
			}
		}

		fclose($archivo);
		return $arrayHelados;
	}

	public static function siguienteId($arrayHelados)
	{
		$proximoId = 0;
		if (isset($arrayHelados))
		{
			foreach ($arrayHelados as $Helado)
			{
				if ($Helado->id > $proximoId)
				{
					$proximoId = $Helado->id;
				}
			}
		}

		return $proximoId + 1;
	}

	public function guardarAlta()
	{
		$linea = json_encode($this->toArray());
		$archivo = fopen("archivos/Helados.txt", "a");
		fputs($archivo, $linea . "\n");
		fclose($archivo);
	}

	public function guardarIngreso()
	{
		$arrayAlta = $this->toArray();
		$arrayIngreso = array();
		$arrayIngreso["tipo"] = $arrayAlta["tipo"];
		$arrayIngreso["stock"] = $arrayAlta["stock"];
		$arrayIngreso["precio"] = date("d/m/Y H:i:s");

		$linea = implode(",", $arrayIngreso);
		$archivo = fopen("archivos/log.csv", "a");
		fputs($archivo, $linea . "\n");
		fclose($archivo);
	}

	public function toArray()
	{
		$retorno = array();

		$retorno["tipo"] = trim($this->tipo);
		$retorno["sabor"] = trim($this->sabor);
		$retorno["stock"] = trim($this->stock);
		$retorno["id"] = trim($this->id);
		$retorno["precio"] = trim($this->precio);

		return $retorno;
	}

	public function getTipo()
	{
		return $this->tipo;
	}

	public function getSabor()
	{
		return $this->sabor;
	}

	public function getStock()
	{
		return $this->stock;
	}
}

?>