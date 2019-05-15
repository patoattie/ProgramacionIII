<?php
require_once "Vehiculo.php";

class Estacionamiento
{
	/*function __construct(argument)
	{
		# code...
	}*/

	public static function ingresarVehiculo($patente)
	{
		if (Estacionamiento::buscarVehiculo($patente))
		{
			
		}
	}

	public static function leerEstacionados()
	{
		$archivo = fopen($_rutaEstacionados, "r");
		$linea = "";
		$arrayDatos = array();
		$retorno = array();

		while (!feof($archivo))
		{
			$linea = fgets($archivo);
			$arrayDatos = explode(";", $linea);
			$auto = new Vehiculo($arrayDatos[0], $arrayDatos[1], $arrayDatos[2]);
			array_push($retorno, $auto);
		}

		fclose($archivo);

		return $retorno;
	}

	public static function buscarVehiculo($patente)
	{
		$arrayVehiculos = leerEstacionados();
		$retorno = false;

		foreach ($arrayVehiculos as $unAuto)
		{
			if (strcmp($patente, $unAuto))
			{
				$retorno = true;
				break;
			}
		}

		return $retorno;
	}
}
?>