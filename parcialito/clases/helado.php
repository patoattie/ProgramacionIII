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
		$archivo = fopen("archivos/helados.txt", "r");
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

	public function guardarAlta()
	{
		$arrayHelados = Helado::leerHelados();
		$hayStock = $this->hayEnStock($arrayHelados);

		if($hayStock < 0) //No hay en stock el helado, agrego una nueva línea.
		{
			$linea = json_encode($this->toArray());
			$archivo = fopen("archivos/helados.txt", "a");
			fputs($archivo, $linea . "\n");
			fclose($archivo);
		}
		else //Hay en stock, reemplazo precio y acumulo stock. Luego vuelvo a escribir el archivo completo.
		{
			$arrayHelados[$hayStock]->precio = $this->precio;
			$arrayHelados[$hayStock]->stock += $this->stock;

			$archivo = fopen("archivos/helados.txt", "w");
			foreach ($arrayHelados as $helado)
			{
				$linea = json_encode($helado->toArray());
				fputs($archivo, $linea . "\n");
			}
			fclose($archivo);
		}
	}

	public function guardarVenta()
	{
		$arrayAlta = $this->toArray();
		$arrayVenta = array();
		$arrayVenta["tipo"] = $arrayAlta["tipo"];
		$arrayVenta["stock"] = $arrayAlta["stock"];
		$arrayVenta["precio"] = date("d/m/Y H:i:s");

		$linea = implode(",", $arrayVenta);
		$archivo = fopen("archivos/log.csv", "a");
		fputs($archivo, $linea . "\n");
		fclose($archivo);
	}

	public function toArray()
	{
		$retorno = array();

		$retorno["tipo"] = trim($this->tipo);
		$retorno["sabor"] = trim($this->sabor);
		$retorno["stock"] = $this->stock;
		$retorno["precio"] = $this->precio;

		return $retorno;
	}

	public function hayEnStock($arrayHelados)
	{
		$posicion = -1;
		$i = 0;

		foreach ($arrayHelados as $helado)
		{
			if($this->tipo === $helado->tipo && $this->sabor === $helado->sabor)
			{
				$posicion = $i;
				break;
			}

			$i++;
		}

		return $posicion;
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

	public function getSabor()
	{
		return $this->sabor;
	}

	public function getStock()
	{
		return $this->stock;
	}

	public function getPrecio()
	{
		return $this->precio;
	}
}

?>