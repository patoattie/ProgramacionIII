<?php
require_once("helado.php");

class AltaVenta
{
	public static function altaVenta($tipo, $sabor, $cantidad, $precio)
	{
		if(Helado::validarTipo($tipo) == 1)
		{
			$helado = new Helado($tipo, $sabor, $cantidad, $precio);
			$venta = AltaVenta::guardarVenta($helado);
			if($venta == -1)
			{
				echo "<br>Se registró la venta del Helado $tipo - $sabor - $cantidad - $precio<br>";
			}
			else if($venta == -2)
			{
				echo "<br>El stock disponible ($venta) no es suficiente para registrar la venta $tipo - $sabor - $cantidad - $precio<br>";
			}
			else
			{
				echo "<br>El stock disponible ($venta) no es suficiente para registrar la venta $tipo - $sabor - $cantidad - $precio<br>";
			}
		}
		else
		{
			echo "<br>Tipo de Helado incorrecto. Ingresó $tipo pero debe ser CREMA o AGUA";
		}
	}

	public static function guardarVenta($helado)
	{
		$retorno = -1;
		$arrayHelados = Helado::leerHelados("archivos/helados.txt");
		$stockRemanente = Helado::hayStockRemanente($arrayHelados, $helado->getTipo(), $helado->getSabor(), $helado->getStock());

		if($stockRemanente >= 0)
		{
			$archivo = fopen("archivos/ventas.txt", "a");
			$linea = json_encode($helado->toArray());
			fputs($archivo, $linea . "\n");
			fclose($archivo);

			$archivo = fopen("archivos/helados.txt", "w");
			foreach ($arrayHelados as $unHelado)
			{
				if($unHelado->esIgual($helado))
				{
					//Guardo en el stock actual ($unHelado) el remanente luego de la venta
					$unHelado->setStock($stockRemanente);
					//$unHelado->setStock($unHelado->getStock() - $helado->getStock());
				}
				$linea = json_encode($unHelado->toArray());
				fputs($archivo, $linea . "\n");
			}	
			fclose($archivo);
		}
		else
		{
			//Devuelvo el stock del producto si no alcanza para la venta
			$retorno = $helado->getStock() + $stockRemanente;
		}

		return $retorno;
	}

	public static function ventaHelado($tipo, $sabor)
	{
		$heladoValido = AltaVenta::obtenerHelado($tipo, $sabor);

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