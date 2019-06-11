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

	public static function leerHelados($archivoTxt)
	{
		$archivo = fopen($archivoTxt, "r");
		$arrayHelados = array();
		$arrayDatos = array();
		$linea = "";

		while (!feof($archivo))
		{
			$linea = fgets($archivo);

			if ((string)$linea != "") //Evito las lineas vacias
			{
				$arrayDatos = json_decode($linea, true); //El segundo parametro en true para que trate la salida como array.
				$helado = new Helado($arrayDatos["tipo"], $arrayDatos["sabor"], $arrayDatos["stock"], $arrayDatos["precio"]);
				array_push($arrayHelados, $helado);
			}
		}

		fclose($archivo);
		return $arrayHelados;
	}

/*	public static function siguienteId($arrayHelados)
	{
		$proximoId = 0;
		if (isset($arrayHelados))
		{
			foreach ($arrayHelados as $helado)
			{
				if ($helado->id > $proximoId)
				{
					$proximoId = $helado->id;
				}
			}
		}

		return $proximoId + 1;
	}*/

	public function toArray()
	{
		$retorno = array();

		$retorno["tipo"] = trim($this->tipo);
		$retorno["sabor"] = trim($this->sabor);
		$retorno["stock"] = $this->stock;
		$retorno["precio"] = $this->precio;

		return $retorno;
	}

	public function esIgual($helado)
	{
		if(strtoupper($this->tipo) == strtoupper($helado->tipo) && strtoupper($this->sabor) == strtoupper($helado->sabor))
		{
			$esIgual = true;
		}
		else
		{
			$esIgual = false;
		}

		return $esIgual;
	}

	public function getTipo()
	{
		return $this->tipo;
	}

	public static function validarTipo($tipo)
	{
		$retorno = 0;

		if(strtolower($tipo) == "crema" || strtolower($tipo) == "agua")
		{
			$retorno = 1;
		}

		return $retorno;
	}

	public static function hayStockRemanente($arrayHelados, $tipo, $sabor, $cantidad)
	{
		$hayStock = -1;

		foreach ($arrayHelados as $helado)
		{
			if(strtoupper($helado->tipo) == strtoupper($tipo) && strtoupper($helado->sabor) == strtoupper($sabor))
			{
				$hayStock = $helado->stock - $cantidad;
				break;
			}
		}

		return $hayStock;
	}

	public static function existeHelado($arrayHelados, $tipo, $sabor)
	{
		$existe = false;

		foreach ($arrayHelados as $helado)
		{
			if(strtoupper($helado->tipo) == strtoupper($tipo) && strtoupper($helado->sabor) == strtoupper($sabor))
			{
				$existe = true;
				break;
			}
		}

		return $existe;
	}

	public function setTipo($tipo)
	{
		if(Helado::validarTipo($tipo) == 1)
		{
			$this->tipo = strtoupper($tipo);
		}
	}

	public function getSabor()
	{
		return $this->sabor;
	}

	public function setSabor($sabor)
	{
		$this->sabor = $sabor;
	}

	public function getStock()
	{
		return $this->stock;
	}

	public function setStock($stock)
	{
		$this->stock = $stock;
	}

	public function getPrecio()
	{
		return $this->precio;
	}

	public function setPrecio($precio)
	{
		$this->precio = $precio;
	}
}

?>