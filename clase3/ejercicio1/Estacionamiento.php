<?php
require_once "Vehiculo.php";

class Estacionamiento
{
	/*function __construct(argument)
	{
		# code...
	}*/

	public static function ingresarVehiculo($patente, $estacionados)
	{

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
}
?>