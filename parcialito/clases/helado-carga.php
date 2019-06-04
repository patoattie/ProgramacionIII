<?php
require_once("helado.php");

class HeladoCarga
{
	public static function altaHelado($tipo, $sabor, $stock, $precio)
	{
		$helado = new Helado($tipo, $sabor, $stock, $precio);
		$helado->guardarAlta();
		echo "<br>Se dio de alta el Helado $tipo - $sabor - $stock - $precio<br>";
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

	public static function obtenerHelado($tipo, $sabor)
	{
		$heladoValido = null;

		foreach (Helado::leerHelados() as $helado)
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