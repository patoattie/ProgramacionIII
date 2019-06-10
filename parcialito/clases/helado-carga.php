<?php
require_once("helado.php");

class HeladoCarga
{
	public static function altaHelado($tipo, $sabor, $stock, $precio)
	{
		if(Helado::validarTipo($tipo) == 1)
		{
			$helado = new Helado($tipo, $sabor, $stock, $precio);
			HeladoCarga::guardarAlta($helado);
			echo "<br>Se dio de alta el Helado $tipo - $sabor - $stock - $precio<br>";
		}
		else
		{
			echo "<br>Tipo de Helado incorrecto. Ingresó $tipo pero debe ser CREMA o AGUA";
		}
	}

	public static function guardarAlta($helado)
	{
		$arrayHelados = Helado::leerHelados("archivos/helados.txt");
		$hayStock = false;

		$archivo = fopen("archivos/helados.txt", "w");

		foreach ($arrayHelados as $unHelado)
		{
			if($helado->esIgual($unHelado)) //Hay en stock, reemplazo precio y acumulo stock.
			{
				$hayStock = true;
				$unHelado->setPrecio($helado->getPrecio());
				$unHelado->setStock($unHelado->getStock() + $helado->getStock());
			}

			$linea = json_encode($unHelado->toArray());
			fputs($archivo, $linea . "\n");
		}

		if(!$hayStock) //No hay en stock el helado, agrego una nueva línea.
		{
			$linea = json_encode($helado->toArray());
			fputs($archivo, $linea . "\n");
		}

		fclose($archivo);
	}

	public static function ventaHelado($tipo, $sabor)
	{
		$heladoValido = HeladoCarga::obtenerHelado($tipo, $sabor);

		if (is_null($heladoValido))
		{
			echo "<br>El helado ingresado no existe<br>";
		}
		else
		{
			$heladoValido->guardarVenta();
			echo "<br>Bienvenido " . $heladoValido->getAlias() . "<br>";
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

	public static function obtenerHelado($tipo, $sabor)
	{
		$heladoValido = null;

		foreach (Helado::leerHelados("archivos/helados.txt") as $helado)
		{
			if ($helado->getTipo() === $tipo && $helado->getSabor() === $sabor)
			{
				$heladoValido = $helado;
				break;
			}
		}

		return $heladoValido;
	}
}
?>